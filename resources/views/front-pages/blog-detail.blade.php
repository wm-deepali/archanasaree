@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/blog-detail/blog-detail.css') }}" />
@endpush

@section('content')
@php
    $author = $blog->author ?: ($general->site_name ?: config('app.name'));
    $shareUrl = urlencode(url()->current());
    $shareText = urlencode($blog->title);
@endphp

<main>
  <section class="blogd-secA">
    <div class="container">
      <ul class="crumb">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><i class="fa-solid fa-chevron-right"></i></li>
        <li><a href="{{ route('blogs') }}">Blog</a></li>
        <li><i class="fa-solid fa-chevron-right"></i></li>
        <li class="current">{{ Str::limit($blog->title, 40) }}</li>
      </ul>
      <div class="ban-grid">
        <div class="ban-content">
          <div class="post-meta">
            @if ($blog->category)<span class="post-cat">{{ $blog->category }}</span>@endif
            <span class="post-date"><i class="fa-regular fa-calendar"></i>
              <time datetime="{{ $blog->display_date->format('Y-m-d') }}">{{ $blog->display_date->format('d M Y') }}</time></span>
            <span class="post-time"><i class="fa-regular fa-clock"></i>{{ $blog->read_time }} min read</span>
          </div>
          <div class="heading"><h1>{{ $blog->title }}</h1></div>
          @if ($blog->short_description)
            <p class="ban-desc">{{ $blog->short_description }}</p>
          @endif
          <div class="ban-by">
            <span class="by-avatar"><i class="fa-regular fa-user"></i></span>
            <div><small>Written by</small><b>{{ $author }}</b></div>
          </div>
        </div>
        <div class="ban-visual">
          <div class="ban-photo">
            <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" />
          </div>
          <span class="ban-tag">The Archana Journal</span>
        </div>
      </div>
    </div>
  </section>

  <section class="blogd-secB">
    <div class="container">
      <article class="blogd-article">
        <div class="blogd-content">
          {!! $blog->body_html !!}
        </div>

        <div class="blogd-foot">
          @if (count($blog->tags_list))
            <ul class="blogd-tags" aria-label="Tags">
              @foreach ($blog->tags_list as $tag)
                <li><a href="javascript:void(0);">{{ $tag }}</a></li>
              @endforeach
            </ul>
          @endif
          <div class="blogd-share">
            <span>Share:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" rel="noopener" aria-label="Share on X"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
            <button type="button" class="copyLink" aria-label="Copy link"><i class="fa-solid fa-link"></i></button>
          </div>
        </div>

        <div class="blogd-author">
          <span class="blogd-avatar"><i class="fa-regular fa-user"></i></span>
          <div>
            <small>Written by</small>
            <h4>{{ $author }}</h4>
          </div>
        </div>
      </article>
    </div>
  </section>

  @if ($related->isNotEmpty())
  <section class="blogd-secC">
    <div class="container">
      <div class="sub-head">
        <span class="eyebrow">Keep Reading</span>
        <div class="heading"><h3>Related Articles</h3></div>
      </div>
      <div class="swiper-wrap">
        <div class="swiper thirdSilder" data-mob="1.2" data-sm="2" data-lg="3" data-xl="4">
          <div class="swiper-wrapper">
            @foreach ($related as $r)
              <div class="swiper-slide">
                <div class="blog-card">
                  <a href="{{ route('blog.show', $r->slug) }}" class="blog-img">
                    <img src="{{ $r->image_url }}" alt="{{ $r->title }}" loading="lazy" />
                    @if ($r->category)<span class="blog-cat">{{ $r->category }}</span>@endif
                  </a>
                  <div class="blog-body">
                    <span class="blog-date"><i class="fa-regular fa-calendar"></i>
                      <time datetime="{{ $r->display_date->format('Y-m-d') }}">{{ $r->display_date->format('d M Y') }}</time></span>
                    <h4><a href="{{ route('blog.show', $r->slug) }}">{{ $r->title }}</a></h4>
                    <p>{{ Str::limit($r->short_description ?: strip_tags($r->content), 110) }}</p>
                    <a href="{{ route('blog.show', $r->slug) }}" class="blog-link">Read More <i class="fa-solid fa-arrow-right-long"></i></a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="swiper-group">
          <button type="button" class="btn-prev" aria-label="Previous slide"><i class="fa-solid fa-arrow-right"></i></button>
          <button type="button" class="btn-next" aria-label="Next slide"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
      </div>
    </div>
  </section>
  @endif
</main>
@endsection