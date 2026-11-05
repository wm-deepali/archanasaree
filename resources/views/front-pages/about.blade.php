@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/sass/about/about.css') }}" />
@endpush

@section('content')

  <main>

    <section class="about-secA">
      <div class="container">
        <ul class="crumb">
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><i class="fa-solid fa-chevron-right"></i></li>
          <li class="current">About Us</li>
        </ul>
        <div class="ban-grid">
          <div class="ban-content">
            @if (filled($hero->eyebrow))
              <span class="eyebrow">{{ $hero->eyebrow }}</span>
            @endif
            <div class="heading">
              <h1>{!! nl2br(e($hero->title)) !!}</h1>
            </div>
            @if (filled($hero->description))
              <p class="ban-desc">{{ $hero->description }}</p>
            @endif
            @if (filled($hero->primary_btn_text) || filled($hero->secondary_btn_text))
              <div class="ban-btns">
                @if (filled($hero->primary_btn_text))
                  <a href="{{ $hero->primary_btn_link ?: route('products') }}"
                    class="btn btn-primary">{{ $hero->primary_btn_text }}</a>
                @endif
                @if (filled($hero->secondary_btn_text))
                  <a href="{{ $hero->secondary_btn_link ?: '#aboutStory' }}"
                    class="btn btn-outline-primary">{{ $hero->secondary_btn_text }}
                    <i class="fa-solid fa-arrow-right-long"></i></a>
                @endif
              </div>
            @endif
          </div>
          <div class="ban-visual">
            <div class="ban-photo">
              <img src="{{ $hero->image_url }}" alt="{{ preg_replace('/\s+/', ' ', $hero->title) }}" />
            </div>
            @if (filled($hero->tag))
              <span class="ban-tag">{{ $hero->tag }}</span>
            @endif
          </div>
        </div>
      </div>
    </section>

    {{-- secB: story --}}
    @if ($s = $about->get('story'))
      <section class="about-secB" id="aboutStory">
        <div class="container">
          <div class="intro-grid">
            <div class="intro-visual">
              <div class="intro-photo">
                <img src="{{ $s->image_url ?? asset('assets/images/home/ower1.jpeg') }}"
                  alt="{{ preg_replace('/\s+/', ' ', $s->title) }}" loading="lazy" />
              </div>
            </div>
            <div class="intro-content">
              @if (filled($s->eyebrow))
                <span class="eyebrow">{{ $s->eyebrow }}</span>
              @endif
              <div class="heading">
                <h3>{!! nl2br(e($s->title)) !!}</h3>
              </div>
              @if (filled($s->description))
                <p>{{ $s->description }}</p>
              @endif
              @if (filled($s->description_2))
                <p>{{ $s->description_2 }}</p>
              @endif

              @php $stats = $s->items->where('group_key', 'stats'); @endphp
              @if ($stats->isNotEmpty())
                <ul class="intro-stats">
                  @foreach ($stats as $stat)
                    <li>
                      <b class="countNum" data-num="{{ $stat->num }}"
                        data-num-icon="{{ $stat->suffix }}">0{{ $stat->suffix }}</b><span>{{ $stat->title }}</span>
                    </li>
                  @endforeach
                </ul>
              @endif
            </div>
          </div>
        </div>
      </section>
    @endif

    {{-- secC: who we are --}}
    @if ($s = $about->get('who'))
      <section class="about-secC">
        <div class="container">
          <div class="who-grid">
            <div class="who-content">
              @if (filled($s->eyebrow))
                <span class="eyebrow">{{ $s->eyebrow }}</span>
              @endif
              <div class="heading">
                <h3>{!! nl2br(e($s->title)) !!}</h3>
              </div>
              @if (filled($s->description))
                <p>{{ $s->description }}</p>
              @endif
              @if (filled($s->description_2))
                <p>{{ $s->description_2 }}</p>
              @endif
              @if (filled($s->description_3))
                <p class="who-note">{{ $s->description_3 }}</p>
              @endif
              @if (filled($s->btn_text))
                <a href="{{ $s->btn_link ?: route('products') }}" class="btn btn-primary">{{ $s->btn_text }}
                  <i class="fa-solid fa-arrow-right-long"></i></a>
              @endif
            </div>
            <div class="who-visual">
              <div class="who-main">
                <img src="{{ $s->image_url ?? asset('assets/images/home/ower2.jpeg') }}"
                  alt="{{ preg_replace('/\s+/', ' ', $s->title) }}" loading="lazy" />
              </div>
              <div class="who-small">
                <img src="{{ $s->image_2_url ?? asset('assets/images/home/ower2.jpeg') }}" alt="" loading="lazy" />
              </div>
              @if (filled($s->tag))
                <span class="who-tag">{{ $s->tag }}</span>
              @endif
            </div>
          </div>
        </div>
      </section>
    @endif

    {{-- secD: philosophy --}}
    @if ($s = $about->get('philosophy'))
      <section class="about-secD">
        <div class="container">
          <div class="sec-head">
            @if (filled($s->eyebrow))
              <span class="eyebrow">{{ $s->eyebrow }}</span>
            @endif
            <div class="heading">
              <h3>{!! nl2br(e($s->title)) !!}</h3>
            </div>
            @if (filled($s->description))
              <p>{{ $s->description }}</p>
            @endif
          </div>
          @php $cards = $s->items->where('group_key', 'cards'); @endphp
          @if ($cards->isNotEmpty())
            <div class="phi-grid">
              @foreach ($cards as $card)
                <div class="phi-card">
                  <span class="phi-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                  <h4>{{ $card->title }}</h4>
                  @if (filled($card->description))
                    <p>{{ $card->description }}</p>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </section>
    @endif

    {{-- secF: art of the saree --}}
    @if ($s = $about->get('art'))
      <section class="about-secF">
        <div class="container">
          <div class="art-grid">
            <a href="{{ route('products') }}" class="art-visual">
              <img src="{{ $s->image_url ?? asset('assets/images/home/offer2.png') }}"
                alt="{{ preg_replace('/\s+/', ' ', $s->title) }}" loading="lazy" />
            </a>
            <div class="art-content">
              @if (filled($s->eyebrow))
                <span class="eyebrow">{{ $s->eyebrow }}</span>
              @endif
              <div class="heading">
                <h3>{!! nl2br(e($s->title)) !!}</h3>
              </div>
              @if (filled($s->description))
                <p>{{ $s->description }}</p>
              @endif

              @php
                $list = $s->items->where('group_key', 'list');
                $tags = $s->items->where('group_key', 'tags');
              @endphp
              @if ($list->isNotEmpty())
                <ul class="art-list">
                  @foreach ($list as $row)
                    <li>
                      <b>{{ $row->title }}</b>@if (filled($row->description))<span>{{ $row->description }}</span>@endif
                    </li>
                  @endforeach
                </ul>
              @endif
              @if ($tags->isNotEmpty())
                <div class="art-tags">
                  @foreach ($tags as $tag)
                    <a href="{{ $tag->link ?: route('products') }}">{{ $tag->title }}</a>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
        </div>
      </section>
    @endif

    {{-- secG: craftsmanship --}}
    @if ($s = $about->get('craft'))
      <section class="about-secG">
        <div class="container">
          <div class="craft-grid">
            <div class="craft-visual">
              <div class="craft-photo">
                <img src="{{ $s->image_url ?? asset('assets/images/home/tab1.png') }}"
                  alt="{{ preg_replace('/\s+/', ' ', $s->title) }}" loading="lazy" />
              </div>
              @if (filled($s->tag))
                <span class="craft-tag">{{ $s->tag }}</span>
              @endif
            </div>
            <div class="craft-content">
              @if (filled($s->eyebrow))
                <span class="eyebrow">{{ $s->eyebrow }}</span>
              @endif
              <div class="heading">
                <h3>{!! nl2br(e($s->title)) !!}</h3>
              </div>
              @php $points = $s->items->where('group_key', 'points'); @endphp
              @if ($points->isNotEmpty())
                <ul class="craft-list">
                  @foreach ($points as $point)
                    <li>
                      <span class="craft-no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                      <div>
                        <h4>{{ $point->title }}</h4>
                        @if (filled($point->description))
                          <p>{{ $point->description }}</p>
                        @endif
                      </div>
                    </li>
                  @endforeach
                </ul>
              @endif
            </div>
          </div>
        </div>
      </section>
    @endif

    {{-- secI: experience --}}
    @if ($s = $about->get('experience'))
      <section class="about-secI">
        <div class="container">
          <div class="exp-grid">
            <div class="exp-intro">
              @if (filled($s->eyebrow))
                <span class="eyebrow">{{ $s->eyebrow }}</span>
              @endif
              <div class="heading">
                <h3>{!! nl2br(e($s->title)) !!}</h3>
              </div>
              @if (filled($s->description))
                <p>{{ $s->description }}</p>
              @endif
              @if (filled($s->btn_text))
                <a href="{{ $s->btn_link ?: route('products') }}" class="btn btn-primary">{{ $s->btn_text }}
                  <i class="fa-solid fa-arrow-right-long"></i></a>
              @endif
            </div>
            <div class="exp-list">
              @foreach ($s->items->where('group_key', 'features') as $item)
                <div class="exp-item">
                  <span class="exp-ico"><i class="fa-solid {{ $item->icon ?: 'fa-star' }}"></i></span>
                  <h4>{{ $item->title }}</h4>
                  @if (filled($item->description))
                    <p>{{ $item->description }}</p>
                  @endif
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </section>
    @endif

    {{-- secL: how it works --}}
    @if ($s = $about->get('how'))
      <section class="about-secL">
        <div class="container">
          <div class="sec-head">
            <div class="heading">
              <h3>{!! nl2br(e($s->title)) !!}</h3>
            </div>
          </div>
          <div class="how-grid">
            @foreach ($s->items->where('group_key', 'steps') as $step)
              <div class="how-item">
                <span class="how-no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <h4>{{ $step->title }}</h4>
                @if (filled($step->description))
                  <p>{{ $step->description }}</p>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      </section>
    @endif

    {{-- secJ: why choose us --}}
    @if ($s = $about->get('why'))
      <section class="about-secJ">
        <div class="container">
          <div class="why-top">
            <div class="why-head">
              @if (filled($s->eyebrow))
                <span class="eyebrow">{{ $s->eyebrow }}</span>
              @endif
              <div class="heading">
                <h3>{!! nl2br(e($s->title)) !!}</h3>
              </div>
            </div>
            @if (filled($s->description))
              <p class="why-sub">{{ $s->description }}</p>
            @endif
          </div>
          <div class="why-grid">
            @foreach ($s->items->where('group_key', 'reasons') as $item)
              <div class="why-item">
                <span class="why-ico"><i class="fa-solid {{ $item->icon ?: 'fa-star' }}"></i></span>
                <h5>{{ $item->title }}</h5>
                @if (filled($item->description))
                  <p>{{ $item->description }}</p>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      </section>
    @endif

    {{-- secK: quote --}}
    @if ($s = $about->get('quote'))
      <section class="about-secK">
        <div class="quote-bg">
          <img src="{{ $s->image_url ?? asset('assets/images/home/offer2.png') }}" alt="" loading="lazy" />
        </div>
        <div class="container">
          <div class="quote-box">
            <p class="quote-text">{!! nl2br(e($s->title)) !!}</p>
            @if (filled($s->tag))
              <span class="quote-by">{{ $s->tag }}</span>
            @endif
          </div>
        </div>
      </section>
    @endif

    <section class="about-secN">
      <div class="container">
        <div class="news-wrap">
          <div class="news-photo">
            <img src="{{ asset('assets/images/home/offer1.jpg') }}" alt="{{ config('app.name') }} new arrivals"
              loading="lazy" />
          </div>
          <div class="news-panel">
            <span class="eyebrow">Stay in the Know</span>
            <div class="heading">
              <h3>Be the First to Discover What's New</h3>
            </div>
            <p class="news-desc">
              Sign up for new arrivals, curated collections, styling
              inspiration and exclusive offers from {{ config('app.name') }}.
            </p>

            <form class="form news-form" action="{{ route('newsletter.subscribe') }}" method="post" novalidate>
              @csrf
              {{-- honeypot --}}
              <input type="text" name="website" tabindex="-1" autocomplete="off"
                style="position:absolute;left:-9999px;opacity:0;height:0;width:0" aria-hidden="true">

              <div class="form-group">
                <input type="email" id="newsEmail" name="email" placeholder=" " required />
                <label for="newsEmail">Enter your email address</label>
              </div>
              <button type="submit" class="btn btn-black">
                Subscribe <i class="fa-solid fa-arrow-right-long"></i>
              </button>
            </form>

            <p class="news-note" id="newsMsg" hidden></p>
            <p class="news-note">
              By subscribing, you agree to receive updates and offers from
              {{ config('app.name') }}.
            </p>
          </div>
        </div>
      </div>
    </section>

  </main>

@endsection