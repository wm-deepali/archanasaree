@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/sass/faqs/faqs.css') }}" />
@endpush

@section('content')
  @php
    $waDigits = preg_replace('/\D/', '', (string) $general->whatsapp);
    if (strlen($waDigits) === 10) {
      $waDigits = '91' . $waDigits;
    }
    $siteName = $general->site_name ?: config('app.name');
  @endphp

  <main>

    <section class="faq-secA">
      <div class="container">
        <ul class="crumb">
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><i class="fa-solid fa-chevron-right"></i></li>
          <li class="current">FAQs</li>
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

    <section class="faq-secB">
      <div class="container">
        <div class="intro-head">
          <span class="eyebrow">Need Some Help?</span>
          <div class="heading">
            <h3>Everything You Need to Know Before You Shop</h3>
          </div>
          <p>
            Whether you're choosing a saree for a celebration, searching for
            your bridal look or checking an order, find quick answers to the
            questions our customers ask most often.
          </p>
        </div>
      </div>
    </section>

    @if ($categories->isNotEmpty())
      <section class="faq-secC">
        <div class="container">
          <div class="faq-layout">

            <ul class="tab-nav">
              @foreach ($categories as $cat)
                <li class="{{ $loop->first ? 'active' : '' }}" data-tab="{{ $loop->iteration }}">
                  <span class="tab-ico"><i class="{{ $cat->icon ?: 'fa-solid fa-circle-question' }}"></i></span>
                  <span class="tab-txt">{{ $cat->name }}</span>
                </li>
              @endforeach
            </ul>

            <div class="tab-nav-content">
              @foreach ($categories as $cat)
                <div class="tabs {{ $loop->first ? 'active' : '' }}" data-tab="{{ $loop->iteration }}">
                  <div class="accordion-wrapper">
                    @foreach ($cat->faqs as $faq)
                      <div class="accordion-item">
                        <div class="accordion-header">
                          <h4>{{ $faq->question }}</h4>
                          <span class="accordion-icon">+</span>
                        </div>
                        <div class="accordion-content">
                          <p>{!! nl2br(e($faq->answer)) !!}</p>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endforeach
            </div>

          </div>
        </div>
      </section>
    @else
      <section class="faq-secC">
        <div class="container">
          <p style="text-align:center">FAQs will be available soon.</p>
        </div>
      </section>
    @endif

    <section class="faq-secD">
      <div class="container">
        <div class="help-box">
          <div class="help-content">
            <span class="eyebrow">Still Have a Question?</span>
            <div class="heading">
              <h3>We're Here to Help</h3>
            </div>
            <p>
              Couldn't find the answer you were looking for? Speak with our team and we'll be happy to help
              you with product details, availability, orders or your next occasion look.
            </p>
          </div>
          <div class="help-btns">
            @if ($waDigits)
              <a href="https://wa.me/{{ $waDigits }}" class="btn btn-primary" target="_blank" rel="noopener">
                <i class="fa-brands fa-whatsapp"></i> WhatsApp Us
              </a>
            @endif
            @if (filled($general->phone ?? null))
              <a href="tel:{{ preg_replace('/[^\d+]/', '', $general->phone) }}" class="btn btn-outline-primary">
                <i class="fa-solid fa-phone"></i> Call Us
              </a>
            @endif
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection