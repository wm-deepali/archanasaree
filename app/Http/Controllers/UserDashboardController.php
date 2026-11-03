<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\State;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\InvoiceSetting;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserDashboardController extends Controller
{
    public function index()
    {
        $customer = auth('customer')->user();
        $customerId = $customer->id;

        $with = [
            'items.product',
            'items.imageVariant',
            'items.skuVariant',
            'items.addons',
            'courier',
            'city',
            'state',
            'billingState',
            'billingCity',
            'invoice',
            'statusHistory',
        ];

        // status => [label, css class]
        $statusMeta = [
            'new' => ['Order Placed', 'processing'],
            'pending' => ['Order Placed', 'processing'],
            'processing' => ['Processing', 'processing'],
            'shipped' => ['Shipped', 'shipped'],
            'delivered' => ['Delivered', 'delivered'],
            'cancelled' => ['Cancelled', 'cancelled'],
            'ndr' => ['Delivery Attempt Failed', 'cancelled'],
            'rto' => ['Returned to Seller', 'cancelled'],
        ];

        // ── Dashboard tab ─────────────────────────────────────
        $counts = Order::where('customer_id', $customerId)
            ->selectRaw('status, COUNT(*) as c')
            ->groupBy('status')
            ->pluck('c', 'status');

        $stats = [
            'total' => $counts->sum(),
            'active' => collect(['new', 'pending', 'processing', 'shipped', 'ndr'])->sum(fn($s) => $counts[$s] ?? 0),
            'delivered' => $counts['delivered'] ?? 0,
            'closed' => ($counts['cancelled'] ?? 0) + ($counts['rto'] ?? 0),
        ];

        $recentOrders = Order::with(['items.product', 'items.imageVariant'])
            ->where('customer_id', $customerId)
            ->latest()
            ->take(3)
            ->get();

        // ── My Orders tab ─────────────────────────────────────
        $orders = Order::with($with)
            ->where('customer_id', $customerId)
            ->latest()
            ->paginate(10, ['*'], 'orders_page');

        // ── Track Order tab ───────────────────────────────────
        $mine = Order::with($with)->where('customer_id', $customerId);
        $trackNo = ltrim(trim((string) request('track')), '#');
        $trackOrder = null;
        $trackError = null;

        if ($trackNo !== '') {
            $trackOrder = (clone $mine)->where('order_number', $trackNo)->first();

            if ($trackOrder && request()->filled('phone')) {
                $last10 = fn($v) => substr(preg_replace('/\D/', '', (string) $v), -10);
                if ($last10(request('phone')) !== $last10($trackOrder->customer_phone)) {
                    $trackOrder = null;
                }
            }

            if (!$trackOrder) {
                $trackError = 'We could not find an order with these details.';
            }
        } else {
            $trackOrder = (clone $mine)
                ->whereIn('status', ['new', 'pending', 'processing', 'shipped', 'ndr'])
                ->latest()->first()
                ?? (clone $mine)->latest()->first();
        }

        // ── Profile tab ───────────────────────────────────────
        $addresses = $customer->addresses()->with(['state', 'city'])
            ->orderByDesc('is_default')->latest()->get();
        $states = State::orderBy('name')->get();

        // ── Wishlist tab ──────────────────────────────────────
        $wishlist = Wishlist::with(['product.category', 'product.subcategory'])
            ->where('customer_id', $customerId)
            ->whereHas('product')          // skip products that were deleted
            ->latest()
            ->get();

        return view('front-pages.dashboard', compact(
            'customer',
            'stats',
            'recentOrders',
            'orders',
            'statusMeta',
            'trackOrder',
            'trackError',
            'addresses',
            'states',
            'wishlist'
        ));
    }

    // Customer-side invoice download (only for their own order)
    public function invoiceDownload(Order $order)
    {
        abort_unless($order->customer_id === auth('customer')->id(), 404);

        $invoice = $order->invoice;
        abort_unless($invoice, 404);

        $order->load(['items.product', 'items.addons', 'state', 'city']);
        $setting = InvoiceSetting::with(['state', 'city'])->first();

        $logo_64 = null;
        if ($setting?->company_logo) {
            $logoPath = storage_path('app/public/' . $setting->company_logo);
            if (file_exists($logoPath)) {
                $logo_64 = 'data:' . mime_content_type($logoPath) . ';base64,' .
                    base64_encode(file_get_contents($logoPath));
            }
        }

        return Pdf::loadView('admin.orders.invoice', [
            'order' => $order,
            'invoice' => $invoice,
            'setting' => $setting,
            'isPdf' => true,
            'logo_64' => $logo_64,
        ])
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'DejaVu Sans', 'isRemoteEnabled' => false, 'isHtml5ParserEnabled' => true, 'dpi' => 150])
            ->download('Invoice-' . $invoice->invoice_number . '.pdf');
    }

    // ── Profile: personal details ─────────────────────────────
    public function updateProfile(Request $request)
    {
        $customer = auth('customer')->user();

        // "+91 98765 43210" -> "9876543210"
        $request->merge(['mobile' => substr(preg_replace('/\D/', '', (string) $request->mobile), -10)]);

        $v = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => ['required', 'regex:/^[6-9]\d{9}$/', Rule::unique('customers', 'mobile')->ignore($customer->id)],
            'dob' => 'nullable|date|before:today',
            'avatar' => 'nullable|image|max:2048',
        ], [
            'mobile.regex' => 'Enter a valid 10 digit mobile number.',
            'mobile.unique' => 'This mobile number is already used by another account.',
            'dob.before' => 'Date of birth must be in the past.',
            'avatar.max' => 'Photo must be 2 MB or smaller.',
        ]);

        $data = [
            'name' => $v['name'],
            'mobile' => $v['mobile'],
            'dob' => !empty($v['dob']) ? Carbon::parse($v['dob'])->toDateString() : null,
        ];

        if ($request->hasFile('avatar')) {
            // avatar may also be a Google profile URL, only delete our own uploads
            if ($customer->avatar && !str_starts_with($customer->avatar, 'http')) {
                Storage::disk('public')->delete($customer->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('customers', 'public');
        }

        $customer->update($data);

        return response()->json(['success' => true, 'message' => 'Profile updated.']);
    }

    // ── Profile: addresses ────────────────────────────────────
    private function addressRules(Request $request): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'state_id' => 'required|exists:states,id',
            'city_id' => ['required', Rule::exists('cities', 'id')->where('state_id', $request->state_id)],
            'pincode' => ['required', 'regex:/^\d{6}$/'],
            'address_type' => 'nullable|in:home,office,other',
        ];
    }

    private function addressMessages(): array
    {
        return [
            'phone.regex' => 'Enter a valid 10 digit mobile number.',
            'pincode.regex' => 'Enter a valid 6 digit pincode.',
            'state_id.required' => 'Please select a state.',
            'city_id.required' => 'Please select a city.',
            'city_id.exists' => 'Please select a city from the chosen state.',
            'address_line_1.required' => 'Please enter your house / flat number.',
        ];
    }

    public function storeAddress(Request $request)
    {
        $customer = auth('customer')->user();
        $v = $request->validate($this->addressRules($request), $this->addressMessages());

        DB::transaction(function () use ($customer, $v, $request) {
            // first address is always the default
            $makeDefault = $request->boolean('is_default') || !$customer->addresses()->exists();

            if ($makeDefault) {
                $customer->addresses()->update(['is_default' => 0]);
            }

            $customer->addresses()->create([
                'name' => $v['name'],
                'email' => $customer->email,
                'phone' => $v['phone'],
                'address_line_1' => $v['address_line_1'],
                'address_line_2' => $v['address_line_2'] ?? null,
                'country' => 'India',
                'state_id' => $v['state_id'],
                'city_id' => $v['city_id'],
                'pincode' => $v['pincode'],
                'address_type' => $v['address_type'] ?? 'home',
                'is_default' => $makeDefault ? 1 : 0,
            ]);
        });

        // GST + shipping follow the default address
        Cart::where('customer_id', $customer->id)->first()?->recalculateTotals();

        return response()->json(['success' => true]);
    }

    public function updateAddress(Request $request, $id)
    {
        $customer = auth('customer')->user();
        $address = $customer->addresses()->findOrFail($id);
        $v = $request->validate($this->addressRules($request), $this->addressMessages());

        DB::transaction(function () use ($customer, $address, $v, $request) {
            $address->update([
                'name' => $v['name'],
                'phone' => $v['phone'],
                'address_line_1' => $v['address_line_1'],
                'address_line_2' => $v['address_line_2'] ?? null,
                'state_id' => $v['state_id'],
                'city_id' => $v['city_id'],
                'pincode' => $v['pincode'],
                'address_type' => $v['address_type'] ?? 'home',
            ]);

            if ($request->boolean('is_default')) {
                $customer->addresses()->update(['is_default' => 0]);
                $address->update(['is_default' => 1]);
            }
        });

        Cart::where('customer_id', $customer->id)->first()?->recalculateTotals();

        return response()->json(['success' => true]);
    }

    public function deleteAddress($id)
    {
        $customer = auth('customer')->user();
        $address = $customer->addresses()->findOrFail($id);

        try {
            DB::transaction(function () use ($customer, $address) {
                $wasDefault = $address->is_default;
                $address->delete();

                // keep one default if any address is left
                if ($wasDefault) {
                    $customer->addresses()->latest()->first()?->update(['is_default' => 1]);
                }
            });
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'This address is linked to a past order and cannot be removed.',
            ], 422);
        }

        Cart::where('customer_id', $customer->id)->first()?->recalculateTotals();

        return response()->json(['success' => true]);
    }

    public function removeWishlist($id)
    {
        $customerId = auth('customer')->id();

        Wishlist::where('customer_id', $customerId)
            ->where('product_id', $id)
            ->delete();

        return response()->json([
            'success' => true,
            'count' => Wishlist::where('customer_id', $customerId)->whereHas('product')->count(),
        ]);
    }

}