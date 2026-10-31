<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Wishlist;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Tracking\CartTracker;

class CustomerAuthController extends Controller
{
    public function registerForm(Request $request)
    {
        return $this->openAuthModal($request, 'register');
    }

    public function loginForm(Request $request)
    {
        return $this->openAuthModal($request, 'login');
    }

    // There are no login pages: send the visitor back and let the layout open the modal
    private function openAuthModal(Request $request, string $tab)
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('home');
        }

        $back = $this->safeUrl($request->input('redirect')) ?? route('home');
        session(['url.intended' => $back]);

        return redirect($back)->with('open_auth', $tab);
    }

    // Same-site URLs only, so ?redirect= can't be used as an open redirect
    private function safeUrl(?string $url): ?string
    {
        if (!$url)
            return null;
        if (str_starts_with($url, '/') && !str_starts_with($url, '//'))
            return url($url);
        $base = url('/');
        return ($url === $base || str_starts_with($url, $base . '/')) ? $url : null;
    }

    // Fallback when there is no intended URL
    private function afterAuthUrl(): string
    {
        return \Illuminate\Support\Facades\Route::has('user.dashboard.index')
            ? route('user.dashboard.index')
            : route('home');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function register(Request $request)
    {
        // alternate_mobile is optional, but if filled must still be a valid format
        $validated = $request->validate(
            [
                'name' => ['required', 'max:100', 'regex:/^[A-Za-z\s]+$/'],
                'email' => ['required', 'email', 'unique:customers,email'],
                'mobile' => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:customers,mobile'],
                'alternate_mobile' => ['nullable', 'regex:/^[6-9]\d{9}$/', 'different:mobile'],
                'password' => ['required', 'min:8', 'confirmed'],
            ],
            [
                'name.regex' => 'Name should contain only letters.',
                'mobile.regex' => 'Enter a valid Indian mobile number.',
                'alternate_mobile.regex' => 'Enter a valid alternate mobile number.',
                'password.confirmed' => 'Password and confirm password do not match.',
            ]
        );

        $customer = Customer::create($validated);

        \App\Services\Email\EmailDispatcher::send(
            'welcome',
            $customer->email,
            [
                '{customer_name}' => $customer->name,
            ]
        );

        // Capture the guest session id BEFORE regenerating it, so the guest
        // cart/wishlist tied to this session can still be found and merged.
        $guestSessionId = session()->getId();

        Auth::guard('customer')->login($customer);

        $this->mergeGuestCart($customer, $guestSessionId);
        $this->mergeGuestWishlist($customer, $guestSessionId);

        $request->session()->regenerate();

        $cart = Cart::where('customer_id', $customer->id)->first();

        CartTracker::linkToCustomer($customer->id, $cart?->id);
        CartTracker::track('signup', $cart, [], 0, $customer->id);

        // Sends the customer back to wherever they came from (e.g. the cart
        // page) instead of always landing on the dashboard after signup.
        return redirect()
            ->intended($this->afterAuthUrl())
            ->with('success', 'Registration completed successfully.')
            ->with('fire_signup_event', 'email_password'); // 👈 new — blade fires Pixel/GA sign_up on this flash
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        // attempt() session ID migrate kar deta hai, isliye PEHLE capture karo
        $guestSessionId = session()->getId();

        if (Auth::guard('customer')->attempt($credentials, $remember)) {

            $customer = Auth::guard('customer')->user();

            $this->mergeGuestCart($customer, $guestSessionId);
            $this->mergeGuestWishlist($customer, $guestSessionId);

            $request->session()->regenerate();

            $cart = Cart::where('customer_id', $customer->id)->first();

            CartTracker::linkToCustomer($customer->id, $cart?->id);
            CartTracker::track('login', $cart, [], 0, $customer->id);

            return redirect()
                ->intended($this->afterAuthUrl())
                ->with('success', 'Login successful.')
                ->with('fire_login_event', true);
        }

        return back()
            ->withInput()
            ->withErrors([
                'email' => 'Invalid email or password.',
            ]);
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $customer = Customer::firstOrCreate(
            [
                'email' => $googleUser->email,
            ],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'avatar' => null,
                'password' => bcrypt(str()->random(20)),
                'mobile' => null,
                'alternate_mobile' => null,
            ]
        );

        $isNewCustomer = $customer->wasRecentlyCreated;

        $guestSessionId = session()->getId();
        Auth::guard('customer')->login($customer);


        $this->mergeGuestCart($customer, $guestSessionId);
        $this->mergeGuestWishlist($customer, $guestSessionId);

        $cart = Cart::where('customer_id', $customer->id)->first();

        CartTracker::linkToCustomer($customer->id, $cart?->id);
        CartTracker::track($isNewCustomer ? 'signup' : 'login', $cart, [], 0, $customer->id);

        if ($isNewCustomer) {
            session()->flash('fire_signup_event', 'google_oauth');
        } else {
            session()->flash('fire_login_event', true);
        }

        return redirect()->intended(route('home'));
    }

    private function mergeGuestCart(Customer $customer, $guestSessionId)
    {
        $guestCart = Cart::with('items.addons')
            ->where('session_id', $guestSessionId)
            ->whereNull('customer_id')
            ->first();

        if (!$guestCart) {
            return;
        }

        $userCart = Cart::firstOrCreate(
            [
                'customer_id' => $customer->id
            ],
            [
                'session_id' => $guestSessionId,
                'total_amount' => 0
            ]
        );

        if ($guestCart->id == $userCart->id) {
            return;
        }

        foreach ($guestCart->items as $item) {

            $existingItem = null;

            if ($item->addons->isEmpty()) {

                $existingItem = CartItem::where('cart_id', $userCart->id)
                    ->where('product_id', $item->product_id)
                    ->where('price_variant_id', $item->price_variant_id)
                    ->where('image_variant_id', $item->image_variant_id)
                    ->where('stock_variant_id', $item->stock_variant_id)
                    ->where('sku_variant_id', $item->sku_variant_id)
                    ->when(
                        !empty($item->custom_colour_code),
                        fn($q) => $q->where('custom_colour_code', $item->custom_colour_code),
                        fn($q) => $q->whereNull('custom_colour_code')
                    )
                    ->doesntHave('addons')
                    ->get()
                    ->first(function ($candidate) use ($item) {
                        return $candidate->selected_attributes === $item->selected_attributes;
                    });
            }

            if ($existingItem) {

                $existingItem->quantity += $item->quantity;
                $existingItem->total =
                    $existingItem->quantity * ($existingItem->price + (float) $existingItem->dye_charge);

                $existingItem->save();

            } else {

                $newItem = CartItem::create([
                    'cart_id' => $userCart->id,
                    'product_id' => $item->product_id,
                    'price_variant_id' => $item->price_variant_id,
                    'image_variant_id' => $item->image_variant_id,
                    'stock_variant_id' => $item->stock_variant_id,
                    'sku_variant_id' => $item->sku_variant_id,
                    'selected_attributes' => $item->selected_attributes,
                    'custom_colour_code' => $item->custom_colour_code,
                    'dye_charge' => $item->dye_charge ?? 0,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total,
                ]);

                foreach ($item->addons as $addon) {
                    $newItem->addons()->create([
                        'addon_id' => $addon->addon_id,
                        'detail' => $addon->detail,
                        'price' => $addon->price,
                    ]);
                }
            }
        }

        // Guest ka coupon carry karo agar user cart mein koi coupon nahi hai
        if (empty($userCart->coupon_code) && !empty($guestCart->coupon_code)) {
            $userCart->update(['coupon_code' => $guestCart->coupon_code]);
        }

        $userCart->update([
            'total_amount' => $userCart->items()->sum('total')
        ]);

        $guestCart->items()->each(function ($item) {
            $item->addons()->delete();
        });
        $guestCart->items()->delete();
        $guestCart->delete();

        // Subtotal, discount, GST sab dobara calculate
        $userCart->refresh();
        $userCart->recalculateTotals();
    }

    private function mergeGuestWishlist(Customer $customer, $guestSessionId)
    {
        $guestWishlistItems = Wishlist::where('session_id', $guestSessionId)->get();

        if ($guestWishlistItems->isEmpty()) {
            return;
        }

        foreach ($guestWishlistItems as $item) {

            $exists = Wishlist::where('customer_id', $customer->id)
                ->where('product_id', $item->product_id)
                ->exists();

            if (!$exists) {
                Wishlist::create([
                    'customer_id' => $customer->id,
                    'session_id' => null,
                    'product_id' => $item->product_id,
                    'expires_at' => $item->expires_at,
                ]);
            }
        }

        Wishlist::where('session_id', $guestSessionId)->delete();
    }

    public function ajaxLogin(Request $request)
    {
        $data = $request->validate([
            'login_id' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $login = trim($data['login_id']);
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $credentials = [$field => $login, 'password' => $data['password']];

        // attempt() se PEHLE capture
        $guestSessionId = session()->getId();

        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {

            $customer = Auth::guard('customer')->user();

            $this->mergeGuestCart($customer, $guestSessionId);
            $this->mergeGuestWishlist($customer, $guestSessionId);

            $request->session()->regenerate();

            $cart = Cart::where('customer_id', $customer->id)->first();

            CartTracker::linkToCustomer($customer->id, $cart?->id);
            CartTracker::track('login', $cart, [], 0, $customer->id);

            return response()->json([
                'success' => true,
                'message' => 'Login successful.',
                'csrf_token' => csrf_token(), // 👈 naya token
                'cart_subtotal' => (float) ($cart ? $cart->items()->sum('total') : 0),
                'tracking_events' => [
                    ['type' => 'gtag', 'name' => 'login', 'params' => (object) []],
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password.',
        ], 422);
    }

    public function ajaxRegister(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'max:100', 'regex:/^[A-Za-z\s]+$/'],
                'email' => ['required', 'email', 'unique:customers,email'],
                'mobile' => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:customers,mobile'],
                'alternate_mobile' => ['nullable', 'regex:/^[6-9]\d{9}$/', 'different:mobile'],
                'password' => ['required', 'min:8', 'confirmed'],
            ],
            [
                'name.regex' => 'Name should contain only letters.',
                'mobile.regex' => 'Enter a valid Indian mobile number.',
                'password.confirmed' => 'Password and confirm password do not match.',
            ]
        );

        $customer = Customer::create($validated);

        \App\Services\Email\EmailDispatcher::send(
            'welcome',
            $customer->email,
            ['{customer_name}' => $customer->name]
        );

        $guestSessionId = session()->getId();

        Auth::guard('customer')->login($customer);

        $this->mergeGuestCart($customer, $guestSessionId);
        $this->mergeGuestWishlist($customer, $guestSessionId);

        $request->session()->regenerate();

        $cart = Cart::where('customer_id', $customer->id)->first();

        CartTracker::linkToCustomer($customer->id, $cart?->id);
        CartTracker::track('signup', $cart, [], 0, $customer->id);

        return response()->json([
            'success' => true,
            'message' => 'Registration completed successfully.',
            'csrf_token' => csrf_token(), // 👈 naya token
            'cart_subtotal' => (float) ($cart ? $cart->items()->sum('total') : 0),
            'tracking_events' => [
                ['type' => 'gtag', 'name' => 'sign_up', 'params' => ['method' => 'email_password']],
            ],
        ]);
    }

    // Google button modal mein bhi hai, isliye redirect remember karna hai
    public function redirectToGoogle(Request $request)
    {
        if ($url = $this->safeUrl($request->input('redirect'))) {
            session(['url.intended' => $url]);
        }

        return Socialite::driver('google')->redirect();
    }

}