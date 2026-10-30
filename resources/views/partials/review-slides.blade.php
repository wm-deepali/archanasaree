{{-- Review slides. Vars: $items (collection of ProductReview), $gid (unique glightbox gallery prefix) --}}
@foreach ($items as $r)
    @php
        $name = $r->customer->name ?? 'Customer';
        $initials = collect(preg_split('/\s+/', trim($name)))
            ->filter()->take(2)
            ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
            ->implode('');
    @endphp
    <div class="swiper-slide">
        <div class="rv-card">
            <div class="rv-top">
                <span class="rv-avatar">{{ $initials ?: 'C' }}</span>
                <div>
                    <h5>{{ $name }}</h5>
                    @if ($r->verified_purchase)
                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i> Verified Purchase</span>
                    @endif
                </div>
            </div>
            <div class="rv-stars">
                @for ($s = 1; $s <= 5; $s++)
                    <i class="{{ $s <= $r->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                @endfor
            </div>
            @if ($r->title)
                <h6>{{ $r->title }}</h6>
            @endif
            @if ($r->review)
                <p>{{ $r->review }}</p>
            @endif
            @if ($r->images->isNotEmpty())
                <div class="rv-photos">
                    @foreach ($r->images as $img)
                        <a href="{{ asset('storage/' . $img->image) }}" class="glightbox"
                            data-gallery="{{ $gid }}-{{ $r->id }}">
                            <img src="{{ asset('storage/' . $img->image) }}" alt="Review photo" loading="lazy" />
                        </a>
                    @endforeach
                </div>
            @endif
            <div class="rv-foot">
                <span class="rv-date">{{ $r->created_at->format('F Y') }}</span>
            </div>
        </div>
    </div>
@endforeach