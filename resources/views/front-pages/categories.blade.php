@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/listing/listing.css') }}" />
    <style>
        .cat-listing { padding: 60px 0; }
        .cat-listing-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        @media (max-width: 1199px) { .cat-listing-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 991px)  { .cat-listing-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; } }
        @media (max-width: 479px)  { .cat-listing-grid { grid-template-columns: 1fr; } }
    </style>
@endpush

@section('title', 'Shop by Category')

@section('content')

    <main>
        <section class="product-banner">
            <div class="banner-img">
                <img src="{{ asset('assets/images/home/banner2.png') }}" alt="Shop by Category" />
            </div>
            <div class="container">
                <ul class="crumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li class="current">Categories</li>
                </ul>
                <div class="banner-content">
                    <span class="eyebrow">Collections</span>
                    <h1>Shop by Category</h1>
                    <p class="banner-desc">
                        From graceful sarees to statement lehengas, discover something
                        made for every celebration.
                    </p>
                </div>
            </div>
        </section>

        <section class="home-secA cat-listing">
            <div class="container">
                <div class="sec-head">
                    <span class="eyebrow">Explore Our Collections</span>
                    <div class="heading">
                        <h3>Find Your Signature Look</h3>
                    </div>
                    <p>
                        From graceful sarees to statement lehengas and unforgettable
                        bridal ensembles, discover something made for every celebration.
                    </p>
                </div>

                @if ($categories->count())
                    <div class="cat-listing-grid">
                        @foreach ($categories as $category)
                            <a href="{{ route('category.show', $category->slug) }}" class="cat-card">
                                <div class="cat-img">
                                    <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('assets/images/home/cat1.png') }}"
                                        alt="{{ $category->name }}" loading="lazy" />
                                </div>
                                <div class="cat-info">
                                    <h4>{{ $category->name }}</h4>
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($category->sub_title ?? ''), 80) ?: 'Explore our curated collection.' }}</p>
                                    <span class="cat-link">Shop {{ $category->name }}
                                        <i class="fa-solid fa-arrow-right-long"></i></span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-center">No categories available right now.</p>
                @endif
            </div>
        </section>
    </main>

@endsection