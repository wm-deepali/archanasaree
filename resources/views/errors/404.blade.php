@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/other/other.css') }}" />
@endpush

@section('content')

    <main>
        <section class="comman-banner error-page">
            <div class="container">
                <div class="error-card">
                    <span class="err-code" aria-hidden="true">404</span>
                    <span class="status">Page Not Found</span>
                    <h1>Oops! This Page Has Gone Missing</h1>
                    <p class="msg">
                        The page you are looking for may have been moved or no longer
                        exists.
                    </p>

                    <div class="btn-grp">
                        <a href="index.html" class="btn btn-primary">
                            <i class="fa-solid fa-house" aria-hidden="true"></i> Back to
                            Home
                        </a>
                        <a href="product-listing.html" class="btn btn-outline-primary">
                            <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> Shop
                            Sarees
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection