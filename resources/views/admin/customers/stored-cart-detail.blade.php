@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
        :root {
            --bg: #f1f2f4; --surface: #fff; --border: #e3e5e8;
            --text-primary: #202223; --text-secondary: #6d7175; --text-hint: #8c9196;
            --accent: #303d89; --accent-light: #f0f1fc;
            --green: #007a5e; --green-bg: #e3f1ec;
            --red: #b22222; --red-bg: #fce8e8;
            --orange: #c84b00; --orange-bg: #fff0e6;
            --radius-sm: 8px; --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        }
        .dp { background: var(--bg); padding: 24px 28px; min-height: 100vh; color: var(--text-primary); font-family: 'Inter', -apple-system, 'Segoe UI', sans-serif; }
        .dp * { box-sizing: border-box; }
        .dp h1 { font-size: 20px; font-weight: 650; margin: 0; }
        .crumb { font-size: 12.5px; color: var(--text-hint); margin: 3px 0 20px; }
        .crumb a { color: var(--accent); text-decoration: none; }
        .crumb span { margin: 0 5px; }
        .card-x { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); padding: 18px 20px; margin-bottom: 18px; }
        .card-x h6 { font-size: 12px; font-weight: 650; text-transform: uppercase; letter-spacing: .05em; color: var(--text-hint); margin: 0 0 14px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 18px; }
        @media(max-width:900px) { .grid-4 { grid-template-columns: repeat(2, 1fr); } .dp { padding: 16px; } }
        .stat { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); padding: 14px 16px; }
        .stat .l { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: var(--text-hint); margin-bottom: 6px; }
        .stat .v { font-size: 18px; font-weight: 700; }
        .stat .s { font-size: 11.5px; color: var(--text-hint); margin-top: 3px; }

        /* stepper */
        .stepper { display: flex; align-items: flex-start; overflow-x: auto; padding-bottom: 4px; }
        .step { flex: 1; min-width: 120px; text-align: center; position: relative; padding: 0 6px; }
        .step::before { content: ''; position: absolute; top: 19px; left: -50%; width: 100%; height: 2px; background: var(--border); z-index: 0; }
        .step:first-child::before { display: none; }
        .step.done::before { background: var(--green); }
        .step-dot { width: 38px; height: 38px; border-radius: 50%; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; background: var(--bg); border: 2px solid var(--border); color: var(--text-hint); font-size: 14px; position: relative; z-index: 1; }
        .step.done .step-dot { background: var(--green-bg); border-color: var(--green); color: var(--green); }
        .step.stop .step-dot { background: var(--red-bg); border-color: var(--red); color: var(--red); }
        .step-label { font-size: 12.5px; font-weight: 600; }
        .step-time { font-size: 11px; color: var(--text-hint); margin-top: 2px; }
        .step-gap { font-size: 11px; color: var(--accent); margin-top: 2px; font-weight: 600; }

        /* timeline */
        .tl { position: relative; padding-left: 28px; }
        .tl::before { content: ''; position: absolute; left: 11px; top: 4px; bottom: 4px; width: 2px; background: var(--border); }
        .tl-item { position: relative; margin-bottom: 18px; }
        .tl-dot { position: absolute; left: -28px; top: 0; width: 24px; height: 24px; border-radius: 50%; background: var(--accent-light); border: 2px solid var(--accent); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 11px; }
        .tl-item.ok .tl-dot { background: var(--green-bg); border-color: var(--green); color: var(--green); }
        .tl-title { font-size: 13.5px; font-weight: 650; }
        .tl-time { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }
        .tl-gap { display: inline-block; margin-left: 8px; background: var(--orange-bg); color: var(--orange); border-radius: 20px; font-size: 11px; font-weight: 600; padding: 1px 8px; }
        .chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
        .chip { background: var(--bg); border: 1px solid var(--border); border-radius: 20px; padding: 3px 10px; font-size: 11.5px; color: var(--text-secondary); }
        .chip i { margin-right: 4px; color: var(--text-hint); }
        .tl-meta { font-size: 12px; color: var(--text-secondary); margin-top: 6px; }

        .item-row { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid var(--border); }
        .item-row:last-child { border-bottom: none; }
        .item-thumb { width: 42px; height: 42px; border-radius: 6px; object-fit: cover; border: 1px solid var(--border); background: var(--bg); }
        .btn-back { display: inline-flex; align-items: center; gap: 6px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 16px; font-size: 13px; color: var(--text-primary) !important; text-decoration: none !important; }
        .row-2 { display: grid; grid-template-columns: 2fr 1fr; gap: 18px; }
        @media(max-width:900px) { .row-2 { grid-template-columns: 1fr; } }
    </style>

    @php
        $u = $cart->user;
        $isGuest = !$u;
        $first = $activities->first();
        $last = $activities->last();

        $fmtGap = function (int $secs) {
            if ($secs < 60) return $secs . 's';
            if ($secs < 3600) return floor($secs / 60) . 'm ' . ($secs % 60) . 's';
            if ($secs < 86400) return floor($secs / 3600) . 'h ' . floor(($secs % 3600) / 60) . 'm';
            return floor($secs / 86400) . 'd ' . floor(($secs % 86400) / 3600) . 'h';
        };

        $deviceIcon = fn($d) => match ($d) { 'mobile' => 'fa-mobile', 'tablet' => 'fa-tablet', default => 'fa-desktop' };

        $steps = [
            ['keys' => ['add_to_cart'], 'label' => 'Add to Cart', 'icon' => 'fa-shopping-cart'],
            ['keys' => ['checkout_viewed'], 'label' => 'Checkout', 'icon' => 'fa-credit-card'],
            ['keys' => ['login_prompt'], 'label' => 'Place Order Click', 'icon' => 'fa-lock'],
            ['keys' => ['login', 'signup'], 'label' => 'Login / Signup', 'icon' => 'fa-user'],
            ['keys' => ['payment_started', 'order_placed'], 'label' => 'Payment', 'icon' => 'fa-inr'],
        ];

        // har step ka pehla event
        $stepEvents = [];
        foreach ($steps as $i => $s) {
            $found = null;
            foreach ($s['keys'] as $k) {
                if (isset($firstByEvent[$k]) && (!$found || $firstByEvent[$k]->created_at->lt($found->created_at))) {
                    $found = $firstByEvent[$k];
                }
            }
            $stepEvents[$i] = $found;
        }

        // pehla step jahan customer ruk gaya
        $stopIndex = null;
        foreach ($stepEvents as $i => $ev) {
            if (!$ev) { $stopIndex = $i; break; }
        }

        $timeToCheckout = (isset($firstByEvent['add_to_cart'], $firstByEvent['checkout_viewed']))
            ? $firstByEvent['checkout_viewed']->created_at->timestamp - $firstByEvent['add_to_cart']->created_at->timestamp
            : null;
    @endphp

    <div class="app-content content container-fluid">
        <div class="dp">

            <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:10px">
                <div>
                    <h1>Cart #{{ $cart->id }} — Journey</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.stored-carts.index') }}">Stored Carts</a><span>›</span>
                        View Detail
                    </div>
                </div>
                <a href="{{ route('admin.stored-carts.index') }}" class="btn-back"><i class="fa fa-arrow-left"></i> Back</a>
            </div>

            {{-- Summary --}}
            <div class="grid-4">
                <div class="stat">
                    <div class="l">Customer</div>
                    <div class="v" style="font-size:15px">{{ $isGuest ? 'Guest User' : $u->name }}</div>
                    <div class="s">
                        @if($isGuest)
                            Not logged in
                        @else
                            {{ $u->email }}@if($u->mobile) · {{ $u->mobile }}@endif
                        @endif
                    </div>
                </div>
                <div class="stat">
                    <div class="l">Cart Value</div>
                    <div class="v" style="color:var(--orange)">₹{{ number_format($cart->grand_total, 0) }}</div>
                    <div class="s">{{ $cart->items->count() }} item(s)</div>
                </div>
                <div class="stat">
                    <div class="l">First Seen</div>
                    <div class="v" style="font-size:15px">{{ $first ? $first->created_at->format('d M Y, h:i A') : $cart->created_at->format('d M Y, h:i A') }}</div>
                    <div class="s">Last activity: {{ $last ? $last->created_at->format('d M, h:i A') : '—' }}</div>
                </div>
                <div class="stat">
                    <div class="l">Cart → Checkout</div>
                    <div class="v" style="font-size:15px">{{ $timeToCheckout !== null ? $fmtGap($timeToCheckout) : 'Never reached' }}</div>
                    <div class="s">Time taken</div>
                </div>
            </div>

            {{-- Funnel stepper --}}
            <div class="card-x">
                <h6>Customer Flow</h6>

                <div class="stepper">
                    <div class="step done">
                        <div class="step-dot"><i class="fa fa-user-o"></i></div>
                        <div class="step-label">{{ $isGuest ? 'Guest User' : 'Customer' }}</div>
                        <div class="step-time">{{ $first ? ucfirst($first->device_type) : '' }}</div>
                    </div>

                    @php $prevEv = null; @endphp
                    @foreach($steps as $i => $s)
                        @php
                            $ev = $stepEvents[$i];
                            $cls = $ev ? 'done' : ($stopIndex === $i ? 'stop' : '');
                        @endphp
                        <div class="step {{ $cls }}">
                            <div class="step-dot">
                                <i class="fa {{ $ev ? $s['icon'] : ($stopIndex === $i ? 'fa-times' : $s['icon']) }}"></i>
                            </div>
                            <div class="step-label">{{ $s['label'] }}</div>
                            @if($ev)
                                <div class="step-time">{{ $ev->created_at->format('d M, h:i A') }}</div>
                                @if($prevEv)
                                    <div class="step-gap">
                                        +{{ $fmtGap(max(0, $ev->created_at->timestamp - $prevEv->created_at->timestamp)) }}
                                    </div>
                                @endif
                                @php $prevEv = $ev; @endphp
                            @else
                                <div class="step-time">{{ $stopIndex === $i ? 'Dropped here' : 'Not reached' }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row-2">
                {{-- Detailed timeline --}}
                <div class="card-x">
                    <h6>Activity Log</h6>

                    @if($activities->isEmpty())
                        <div style="color:var(--text-hint);font-size:13px">
                            Is cart ka koi tracking data nahi hai (tracking shuru hone se pehle ka cart).
                        </div>
                    @else
                        <div class="tl">
                            @php $prev = null; @endphp
                            @foreach($activities as $a)
                                @php
                                    $meta = $a->meta ?? [];
                                    $gap = $prev ? max(0, $a->created_at->timestamp - $prev->created_at->timestamp) : null;
                                    $ok = in_array($a->event, ['login', 'signup', 'payment_started', 'order_placed']);
                                @endphp
                                <div class="tl-item {{ $ok ? 'ok' : '' }}">
                                    <div class="tl-dot"><i class="fa {{ $a->icon }}"></i></div>
                                    <div class="tl-title">{{ $a->label }}</div>
                                    <div class="tl-time">
                                        {{ $a->created_at->format('d M Y, h:i:s A') }}
                                        @if($gap !== null)
                                            <span class="tl-gap">+{{ $fmtGap($gap) }}</span>
                                        @endif
                                    </div>

                                    @if(!empty($meta['product']))
                                        <div class="tl-meta">
                                            {{ $meta['product'] }}
                                            @if(!empty($meta['quantity'])) × {{ $meta['quantity'] }} @endif
                                            @if(!empty($meta['price'])) — ₹{{ number_format((float) $meta['price'], 0) }} @endif
                                        </div>
                                    @endif
                                    @if(!empty($meta['order_number']))
                                        <div class="tl-meta">
                                            Order {{ $meta['order_number'] }}
                                            @if(!empty($meta['method'])) · {{ strtoupper($meta['method']) }} @endif
                                            @if(!empty($meta['amount'])) · ₹{{ number_format((float) $meta['amount'], 0) }} @endif
                                        </div>
                                    @endif

                                    <div class="chips">
                                        <span class="chip"><i class="fa {{ $deviceIcon($a->device_type) }}"></i>{{ ucfirst($a->device_type ?? '—') }}</span>
                                        <span class="chip"><i class="fa fa-globe"></i>{{ $a->browser ?? '—' }} / {{ $a->os ?? '—' }}</span>
                                        <span class="chip"><i class="fa fa-wifi"></i>{{ $a->ip_address ?? '—' }}</span>
                                        <span class="chip"><i class="fa fa-map-marker"></i>{{ $a->location_label ?? 'Location unknown' }}</span>
                                        @if($a->referrer)
                                            <span class="chip" title="{{ $a->referrer }}"><i class="fa fa-external-link"></i>{{ \Illuminate\Support\Str::limit(parse_url($a->referrer, PHP_URL_HOST) ?: $a->referrer, 28) }}</span>
                                        @endif
                                    </div>
                                </div>
                                @php $prev = $a; @endphp
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Cart items --}}
                <div class="card-x">
                    <h6>Cart Items</h6>

                    @foreach($cart->items as $item)
                        @php
                            $thumb = ($item->imageVariant && $item->imageVariant->image)
                                ? $item->imageVariant->image
                                : optional($item->product)->thumbnail;

                            $variantLabel = null;
                            if (!empty($item->selected_attributes)) {
                                $variantLabel = collect($item->selected_attributes)
                                    ->map(function ($value, $key) {
                                        if (is_array($value)) {
                                            return ($value['attribute'] ?? $value['name'] ?? $key) . ': ' . ($value['value'] ?? $value['label'] ?? reset($value));
                                        }
                                        return $key . ': ' . $value;
                                    })->join(' · ');
                            }
                        @endphp
                        <div class="item-row">
                            @if($thumb)
                                <img src="{{ asset('storage/' . $thumb) }}" class="item-thumb" alt="">
                            @else
                                <div class="item-thumb"></div>
                            @endif
                            <div style="flex:1;min-width:0">
                                <div style="font-size:13px;font-weight:600">{{ optional($item->product)->name ?? 'Unknown Product' }}</div>
                                <div style="font-size:11.5px;color:var(--text-hint)">
                                    {{ $variantLabel }} @if($variantLabel) · @endif Qty {{ $item->quantity }}
                                </div>
                            </div>
                            <div style="font-size:13px;font-weight:700">₹{{ number_format($item->total, 0) }}</div>
                        </div>
                    @endforeach

                    @if($cart->coupon_code)
                        <div style="margin-top:10px;font-size:12.5px;color:var(--green)">
                            <i class="fa fa-tag"></i> Coupon: <strong>{{ $cart->coupon_code }}</strong>
                            (−₹{{ number_format($cart->discount, 0) }})
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')