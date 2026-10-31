<?php

namespace App\Services\Tracking;

use App\Models\Cart;
use App\Models\CartActivity;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CartTracker
{
    public const COOKIE = 'aq_vid';

    /**
     * Har browser ko ek permanent anonymous ID (1 saal).
     */
    public static function visitorId(): string
    {
        $request = request();

        if ($id = $request->attributes->get('aq_vid')) {
            return $id;
        }

        $id = $request->cookie(self::COOKIE);

        if (!$id || !Str::isUuid($id)) {
            $id = (string) Str::uuid();
            Cookie::queue(self::COOKIE, $id, 60 * 24 * 365);
        }

        $request->attributes->set('aq_vid', $id);

        return $id;
    }

    /**
     * Ek step ka record. Kabhi bhi checkout/cart ko break nahi karega.
     *
     * $dedupeMinutes > 0 => same visitor+event+cart ka record itne minute mein dobara nahi banega
     */
    public static function track(
        string $event,
        ?Cart $cart = null,
        array $meta = [],
        int $dedupeMinutes = 0,
        ?int $customerId = null
    ): void {
        try {
            $request = request();
            $visitorId = self::visitorId();
            $customerId = $customerId ?? auth('customer')->id();

            if ($dedupeMinutes > 0) {
                $exists = CartActivity::where('visitor_id', $visitorId)
                    ->where('event', $event)
                    ->when($cart, fn($q) => $q->where('cart_id', $cart->id))
                    ->where('created_at', '>=', now()->subMinutes($dedupeMinutes))
                    ->exists();

                if ($exists) {
                    return;
                }
            }

            $ua = (string) $request->userAgent();
            [$device, $browser, $os] = self::parseUserAgent($ua);

            $itemsCount = null;
            if ($cart) {
                $itemsCount = $cart->relationLoaded('items')
                    ? $cart->items->count()
                    : $cart->items()->count();
            }

            $activity = CartActivity::create([
                'visitor_id' => $visitorId,
                'cart_id' => $cart?->id,
                'customer_id' => $customerId,
                'event' => $event,
                'cart_total' => $cart?->grand_total,
                'items_count' => $itemsCount,
                'ip_address' => $request->ip(),
                'device_type' => $device,
                'browser' => $browser,
                'os' => $os,
                'user_agent' => mb_substr($ua, 0, 1000),
                'referrer' => mb_substr((string) $request->headers->get('referer'), 0, 500) ?: null,
                'meta' => $meta ?: null,
            ]);

            self::resolveLocationAfterResponse($activity);

        } catch (\Throwable $e) {
            Log::warning('CartTracker failed: ' . $e->getMessage());
        }
    }

    /**
     * Login / signup ke baad: is visitor ki guest history customer se jod do
     * aur purane (delete ho chuke) guest cart ki jagah user cart ka id daal do.
     */
    public static function linkToCustomer(int $customerId, ?int $cartId = null): void
    {
        try {
            $update = ['customer_id' => $customerId];

            if ($cartId) {
                $update['cart_id'] = $cartId;
            }

            CartActivity::where('visitor_id', self::visitorId())
                ->whereNull('customer_id')
                ->update($update);

        } catch (\Throwable $e) {
            Log::warning('CartTracker link failed: ' . $e->getMessage());
        }
    }

    /**
     * IP se location, response bhejne ke BAAD (user ko slow nahi karega).
     * ipwho.is free hai (HTTPS). Zyada traffic ho to MaxMind GeoLite2 local DB use karna.
     */
    private static function resolveLocationAfterResponse(CartActivity $activity): void
    {
        $ip = $activity->ip_address;

        if (!$ip || !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return;
        }

        $id = $activity->id;

        dispatch(function () use ($id, $ip) {
            try {
                $geo = Cache::remember('geoip:' . $ip, now()->addDays(30), function () use ($ip) {
                    $res = Http::timeout(3)->get("https://ipwho.is/{$ip}");
                    $json = $res->json();

                    if ($res->ok() && ($json['success'] ?? false)) {
                        return [
                            'country' => $json['country'] ?? null,
                            'region' => $json['region'] ?? null,
                            'city' => $json['city'] ?? null,
                        ];
                    }

                    return null;
                });

                if ($geo) {
                    CartActivity::whereKey($id)->update($geo);
                }
            } catch (\Throwable $e) {
                Log::info('Geo lookup failed: ' . $e->getMessage());
            }
        })->afterResponse();
    }

    private static function parseUserAgent(string $ua): array
    {
        $device = 'desktop';

        if (preg_match('/iPad|Tablet|PlayBook|Silk/i', $ua)
            || (preg_match('/Android/i', $ua) && !preg_match('/Mobile/i', $ua))) {
            $device = 'tablet';
        } elseif (preg_match('/Mobile|iPhone|iPod|Android|Opera Mini|IEMobile/i', $ua)) {
            $device = 'mobile';
        }

        $browser = match (true) {
            (bool) preg_match('/Instagram/i', $ua) => 'Instagram in-app',
            (bool) preg_match('/FBAN|FBAV/i', $ua) => 'Facebook in-app',
            (bool) preg_match('/Edg(e|A|iOS)?\//i', $ua) => 'Edge',
            (bool) preg_match('/OPR\/|Opera/i', $ua) => 'Opera',
            (bool) preg_match('/SamsungBrowser/i', $ua) => 'Samsung Internet',
            (bool) preg_match('/CriOS|Chrome/i', $ua) => 'Chrome',
            (bool) preg_match('/FxiOS|Firefox/i', $ua) => 'Firefox',
            (bool) preg_match('/Safari/i', $ua) => 'Safari',
            default => 'Unknown',
        };

        $os = match (true) {
            (bool) preg_match('/Android/i', $ua) => 'Android',
            (bool) preg_match('/iPhone|iPad|iPod/i', $ua) => 'iOS',
            (bool) preg_match('/Windows/i', $ua) => 'Windows',
            (bool) preg_match('/Macintosh|Mac OS X/i', $ua) => 'macOS',
            (bool) preg_match('/Linux/i', $ua) => 'Linux',
            default => 'Unknown',
        };

        return [$device, $browser, $os];
    }
}