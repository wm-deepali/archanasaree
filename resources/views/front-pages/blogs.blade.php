@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/sass/blogs/blogs.css') }}" />
@endpush

@section('content')

  <main>

    <section class="blog-secA">
      <div class="container">
        <ul class="crumb">
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><i class="fa-solid fa-chevron-right"></i></li>
          <li class="current">Blog</li>
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

    @if ($featured)
      <section class="blog-secB">
        <div class="container">
          <div class="feat-card">
            <a href="{{ route('blog.show', $featured->slug) }}" class="feat-img">
              <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}" loading="lazy" />
              <span class="feat-tag">Featured</span>
            </a>
            <div class="feat-content">
              <div class="post-meta">
                <span class="post-date"><i class="fa-regular fa-calendar"></i>
                  <time
                    datetime="{{ $featured->display_date->format('Y-m-d') }}">{{ $featured->display_date->format('d M Y') }}</time></span>
                @if ($featured->category)
                  <span class="post-cat">{{ $featured->category }}</span>
                @endif
              </div>
              <h3><a href="{{ route('blog.show', $featured->slug) }}">{{ $featured->title }}</a></h3>
              <p>{{ Str::limit($featured->short_description ?: strip_tags($featured->content), 180) }}</p>
              <a href="{{ route('blog.show', $featured->slug) }}" class="btn btn-primary">
                Read Article <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
          </div>
        </div>
      </section>
    @endif

    <section class="blog-secC">
      <div class="container">
        @if ($blogs->isNotEmpty())
          <div class="sub-head">
            <span class="eyebrow">More to Read</span>
            <div class="heading">
              <h3>Latest From the Journal</h3>
            </div>
          </div>

          <div class="blog-grid">
            @foreach ($blogs as $blog)
              <div class="blog-card">
                <a href="{{ route('blog.show', $blog->slug) }}" class="blog-img">
                  <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" loading="lazy" />
                  @if ($blog->category)<span class="blog-cat">{{ $blog->category }}</span>@endif
                </a>
                <div class="blog-body">
                  <span class="blog-date"><i class="fa-regular fa-calendar"></i>
                    <time
                      datetime="{{ $blog->display_date->format('Y-m-d') }}">{{ $blog->display_date->format('d M Y') }}</time></span>
                  <h4><a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a></h4>
                  <p>{{ Str::limit($blog->short_description ?: strip_tags($blog->content), 120) }}</p>
                  <a href="{{ route('blog.show', $blog->slug) }}" class="blog-link">
                    Read More <i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
              </div>
            @endforeach
          </div>

          @if ($blogs->hasPages())
            <ul class="blog-pager">
              <li>
                <a href="{{ $blogs->previousPageUrl() ?: '#' }}" class="pg-arrow" aria-label="Previous page">
                  <i class="fa-solid fa-arrow-left-long"></i></a>
              </li>
              @foreach ($blogs->getUrlRange(max(1, $blogs->currentPage() - 2), min($blogs->lastPage(), $blogs->currentPage() + 2)) as $page => $url)
                <li><a href="{{ $url }}" class="{{ $page == $blogs->currentPage() ? 'active' : '' }}">{{ $page }}</a></li>
              @endforeach
              <li>
                <a href="{{ $blogs->nextPageUrl() ?: '#' }}" class="pg-arrow" aria-label="Next page">
                  <i class="fa-solid fa-arrow-right-long"></i></a>
              </li>
            </ul>
          @endif
        @elseif (!$featured)
          <p style="text-align:center">Our journal is coming soon.</p>
        @endif
      </div>
    </section>

    <section class="blog-secD">
      <div class="container">
        <div class="help-box">
          <div class="help-content">
            <span class="eyebrow">Ready to Shop?</span>
            <div class="heading">
              <h3>Find the Drape You Have Been Imagining</h3>
            </div>
            <p>
              Explore our sarees, lehengas and bridal wear, chosen for the
              moments that matter.
            </p>
          </div>
          <div class="help-btns">
            <a href="{{ route('products') }}" class="btn btn-primary">Shop Sarees</a>
            <a href="{{ route('categories') }}" class="btn btn-outline-primary">Explore Collections <i
                class="fa-solid fa-arrow-right-long"></i></a>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection