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
                        <span class="eyebrow">Archana Saree Emporium</span>
                        <div class="heading">
                            <h1>A Legacy of <br />Timeless Indian Elegance</h1>
                        </div>
                        <p class="ban-desc">
                            Celebrating the beauty of Indian drapes through timeless
                            craftsmanship, thoughtful curation and styles made for life's
                            most memorable occasions.
                        </p>
                        <div class="ban-btns">
                            <a href="{{ route('categories') }}" class="btn btn-primary">Explore Our Collection</a>
                            <a href="#aboutStory" class="btn btn-outline-primary">Discover Our Story
                                <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                    <div class="ban-visual">
                        <div class="ban-photo">
                            <img src="assets/images/home/banner5.jpg" alt="Archana Saree Emporium editorial saree look" />
                        </div>
                        <span class="ban-tag">The Archana Edit</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-secB" id="aboutStory">
            <div class="container">
                <div class="intro-grid">
                    <div class="intro-visual">
                        <div class="intro-photo">
                            <img src="assets/images/home/ower1.jpeg" alt="Archana Saree Emporium store" loading="lazy" />
                        </div>
                    </div>
                    <div class="intro-content">
                        <span class="eyebrow">The Archana Story</span>
                        <div class="heading">
                            <h3>Rooted in Tradition. <br />Curated for Today.</h3>
                        </div>
                        <p>
                            Archana Saree Emporium brings together timeless Indian textiles
                            and a contemporary eye for styling, for women who appreciate
                            quality, craftsmanship and quiet elegance.
                        </p>
                        <p>
                            Every saree is chosen for the way it feels, drapes and
                            photographs in real life, so that what arrives at your door is
                            exactly what you imagined when you first saw it.
                        </p>
                        <ul class="intro-stats">
                            <li>
                                <b class="countNum" data-num="25" data-num-icon="+">0+</b><span>Years of Experience</span>
                            </li>
                            <li>
                                <b class="countNum" data-num="120" data-num-icon="+">0+</b><span>Curated Collections</span>
                            </li>
                            <li>
                                <b class="countNum" data-num="10000" data-num-icon="+">0+</b><span>Happy Customers</span>
                            </li>
                            <li>
                                <b class="countNum" data-num="5000" data-num-icon="+">0+</b><span>Celebrations
                                    Dressed</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-secC">
            <div class="container">
                <div class="who-grid">
                    <div class="who-content">
                        <span class="eyebrow">Who We Are</span>
                        <div class="heading">
                            <h3>More Than a Saree Store</h3>
                        </div>
                        <p>
                            Archana Saree Emporium is built around one simple idea: helping
                            you find the right saree for the moments that matter. Weddings,
                            festivities, family celebrations and the everyday occasions that
                            deserve a little more grace.
                        </p>
                        <p>
                            We believe a saree is never just a garment. It is a feeling, a
                            tradition passed on and a story you carry from one celebration
                            to the next.
                        </p>
                        <p class="who-note">
                            Our work is to make that choice feel effortless, personal and
                            beautifully unhurried.
                        </p>
                        <a href="{{ route('categories') }}" class="btn btn-primary">Explore Sarees <i
                                class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                    <div class="who-visual">
                        <div class="who-main">
                            <img src="assets/images/home/offer2.png" alt="Saree draped for a celebration" loading="lazy" />
                        </div>
                        <div class="who-small">
                            <img src="assets/images/home/ower2.jpeg" alt="Fabric and craftsmanship" loading="lazy" />
                        </div>
                        <span class="who-tag">Made for Moments</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-secD">
            <div class="container">
                <div class="sec-head">
                    <span class="eyebrow">Our Philosophy</span>
                    <div class="heading">
                        <h3>Elegance Begins With What You Choose.</h3>
                    </div>
                    <p>Four quiet beliefs shape every collection we bring to you.</p>
                </div>
                <div class="phi-grid">
                    <div class="phi-card">
                        <span class="phi-num">01</span>
                        <h4>Timeless Craftsmanship</h4>
                        <p>
                            Weaves, borders and finishes that reward a closer look and last
                            well beyond a single season.
                        </p>
                    </div>
                    <div class="phi-card">
                        <span class="phi-num">02</span>
                        <h4>Thoughtful Curation</h4>
                        <p>
                            Fewer, better pieces, chosen for colour, drape and the occasions
                            they were made for.
                        </p>
                    </div>
                    <div class="phi-card">
                        <span class="phi-num">03</span>
                        <h4>Authentic Indian Elegance</h4>
                        <p>
                            Respect for regional textiles, rooted in tradition and styled
                            with a modern point of view.
                        </p>
                    </div>
                    <div class="phi-card">
                        <span class="phi-num">04</span>
                        <h4>Customer First</h4>
                        <p>
                            Honest guidance, careful packing and a team that stays with you
                            long after the order.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-secF">
            <div class="container">
                <div class="art-grid">
                    <a href="{{ route('categories') }}" class="art-visual">
                        <img src="assets/images/home/offer2.png" alt="The art of the saree" loading="lazy" />
                    </a>
                    <div class="art-content">
                        <span class="eyebrow">The Art of the Saree</span>
                        <div class="heading">
                            <h3>Every Drape Has a Story.</h3>
                        </div>
                        <p>
                            Six yards, countless decisions. Here is what we look at before a
                            saree earns its place in our collection.
                        </p>
                        <ul class="art-list">
                            <li>
                                <b>Fabric</b><span>Soft, breathable and kind to the skin.</span>
                            </li>
                            <li>
                                <b>Weave</b><span>Even, dense and true to its tradition.</span>
                            </li>
                            <li>
                                <b>Border</b><span>The frame that gives a drape its character.</span>
                            </li>
                            <li>
                                <b>Embroidery</b><span>Fine, secure and thoughtfully placed.</span>
                            </li>
                            <li>
                                <b>Zari</b><span>A warm glow, never harsh or heavy.</span>
                            </li>
                            <li>
                                <b>Colour</b><span>Rich, balanced and flattering in daylight.</span>
                            </li>
                            <li>
                                <b>Drape</b><span>Falls beautifully and holds its pleats.</span>
                            </li>
                            <li>
                                <b>Occasion</b><span>Chosen for the moment it will be worn in.</span>
                            </li>
                        </ul>
                        <div class="art-tags">
                            <a href="{{ route('products') }}">Banarasi</a>
                            <a href="{{ route('products') }}">Kanjivaram</a>
                            <a href="{{ route('products') }}">Organza</a>
                            <a href="{{ route('products') }}">Silk</a>
                            <a href="{{ route('products') }}">Georgette</a>
                            <a href="{{ route('products') }}">Chiffon</a>
                            <a href="{{ route('products') }}">Festive</a>
                            <a href="{{ route('products') }}">Bridal</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-secG">
            <div class="container">
                <div class="craft-grid">
                    <div class="craft-visual">
                        <div class="craft-photo">
                            <img src="assets/images/home/tab1.png" alt="Saree weave and zari detail" loading="lazy" />
                        </div>
                        <span class="craft-tag">In Detail</span>
                    </div>
                    <div class="craft-content">
                        <span class="eyebrow">Craftsmanship</span>
                        <div class="heading">
                            <h3>Made to Be Admired. <br />Chosen to Be Remembered.</h3>
                        </div>
                        <ul class="craft-list">
                            <li>
                                <span class="craft-no">01</span>
                                <div>
                                    <h4>Intricate Details</h4>
                                    <p>
                                        Hand-finished borders and delicate embroidery that reveal
                                        more the closer you look.
                                    </p>
                                </div>
                            </li>
                            <li>
                                <span class="craft-no">02</span>
                                <div>
                                    <h4>Rich Textures</h4>
                                    <p>
                                        Fabrics with weight, softness and movement, so every pleat
                                        falls the way it should.
                                    </p>
                                </div>
                            </li>
                            <li>
                                <span class="craft-no">03</span>
                                <div>
                                    <h4>Timeless Weaves</h4>
                                    <p>
                                        Classic patterns and zari work with a quiet, enduring
                                        character.
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-secH">
            <div class="container">
                <div class="sec-head">
                    <span class="eyebrow">Our Collections</span>
                    <div class="heading">
                        <h3>Curated for Every Celebration</h3>
                    </div>
                    <p>
                        Four collections, each chosen to make a different occasion feel
                        unforgettable.
                    </p>
                </div>
                <div class="swiper-wrap">
                    <div class="swiper fourSlider" data-mob="1.2" data-sm="2" data-lg="3" data-xl="4">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="{{ route('categories') }}" class="col-card">
                                    <img src="assets/images/home/cat1.png" alt="Premium Sarees" loading="lazy" />
                                    <div class="col-info">
                                        <h4>Premium Sarees</h4>
                                        <p>Timeless drapes, beautiful craftsmanship.</p>
                                        <span class="col-link">Explore <i class="fa-solid fa-arrow-right-long"></i></span>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ route('categories') }}" class="col-card">
                                    <img src="assets/images/home/cat2.png" alt="Designer Lehengas" loading="lazy" />
                                    <div class="col-info">
                                        <h4>Designer Lehengas</h4>
                                        <p>Statement silhouettes for grand occasions.</p>
                                        <span class="col-link">Explore <i class="fa-solid fa-arrow-right-long"></i></span>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ route('categories') }}" class="col-card">
                                    <img src="assets/images/home/cat4.png" alt="Bridal Wear" loading="lazy" />
                                    <div class="col-info">
                                        <h4>Bridal Wear</h4>
                                        <p>Extraordinary pieces for your most memorable day.</p>
                                        <span class="col-link">Explore <i class="fa-solid fa-arrow-right-long"></i></span>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ route('categories') }}" class="col-card">
                                    <img src="assets/images/home/cat3.png" alt="Festive and Party Wear" loading="lazy" />
                                    <div class="col-info">
                                        <h4>Festive &amp; Party Wear</h4>
                                        <p>Graceful styles for evenings that sparkle.</p>
                                        <span class="col-link">Explore <i class="fa-solid fa-arrow-right-long"></i></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-group">
                        <button type="button" class="btn-prev" aria-label="Previous slide">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        <button type="button" class="btn-next" aria-label="Next slide">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-secI">
            <div class="container">
                <div class="exp-grid">
                    <div class="exp-intro">
                        <span class="eyebrow">The Archana Experience</span>
                        <div class="heading">
                            <h3>An Experience Beyond the Drape</h3>
                        </div>
                        <p>
                            Why shop with us? Because choosing a saree should feel as
                            beautiful as wearing one.
                        </p>
                        <a href="{{ route('categories') }}" class="btn btn-primary">Start Exploring <i
                                class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                    <div class="exp-list">
                        <div class="exp-item">
                            <span class="exp-ico"><i class="fa-solid fa-wand-magic-sparkles"></i></span>
                            <h4>Thoughtfully Curated</h4>
                            <p>
                                Every piece is selected for beauty, wearability and the way it
                                carries an occasion.
                            </p>
                        </div>
                        <div class="exp-item">
                            <span class="exp-ico"><i class="fa-solid fa-eye"></i></span>
                            <h4>Quality You Can See</h4>
                            <p>
                                Honest photography and clear details, so what you see is what
                                you receive.
                            </p>
                        </div>
                        <div class="exp-item">
                            <span class="exp-ico"><i class="fa-solid fa-comments"></i></span>
                            <h4>Personal Assistance</h4>
                            <p>
                                Real guidance on colour, fabric and styling, whenever you need
                                it.
                            </p>
                        </div>
                        <div class="exp-item">
                            <span class="exp-ico"><i class="fa-solid fa-calendar-check"></i></span>
                            <h4>Made for Every Occasion</h4>
                            <p>
                                From intimate gatherings to grand weddings, there is a drape
                                for every moment.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-secJ">
            <div class="container">
                <div class="why-top">
                    <div class="why-head">
                        <span class="eyebrow">Why Choose Us</span>
                        <div class="heading">
                            <h3>Why Women Choose Archana</h3>
                        </div>
                    </div>
                    <p class="why-sub">
                        Six reasons our customers return, season after season.
                    </p>
                </div>
                <div class="why-grid">
                    <div class="why-item">
                        <div class="why-row">
                            <i class="fa-solid fa-layer-group"></i><span>01</span>
                        </div>
                        <h5>Curated Saree Collections</h5>
                        <p>Handpicked styles, never a crowded catalogue.</p>
                    </div>
                    <div class="why-item">
                        <div class="why-row">
                            <i class="fa-solid fa-gem"></i><span>02</span>
                        </div>
                        <h5>Premium Fabrics &amp; Finishes</h5>
                        <p>Rich textiles with a finish that lasts.</p>
                    </div>
                    <div class="why-item">
                        <div class="why-row">
                            <i class="fa-solid fa-champagne-glasses"></i><span>03</span>
                        </div>
                        <h5>Styles for Every Occasion</h5>
                        <p>Weddings, festivals, parties and everyday grace.</p>
                    </div>
                    <div class="why-item">
                        <div class="why-row">
                            <i class="fa-solid fa-hand-holding-heart"></i><span>04</span>
                        </div>
                        <h5>Personalised Assistance</h5>
                        <p>Advice that feels like it comes from a friend.</p>
                    </div>
                    <div class="why-item">
                        <div class="why-row">
                            <i class="fa-solid fa-shield-halved"></i><span>05</span>
                        </div>
                        <h5>Secure Shopping</h5>
                        <p>Safe payments and careful handling of your details.</p>
                    </div>
                    <div class="why-item">
                        <div class="why-row">
                            <i class="fa-solid fa-truck-fast"></i><span>06</span>
                        </div>
                        <h5>Reliable Delivery &amp; Support</h5>
                        <p>Packed with care, delivered on time, help one message away.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-secK">
            <div class="quote-bg">
                <img src="assets/images/home/offer2.png" alt="Saree editorial" loading="lazy" />
            </div>
            <div class="container">
                <div class="quote-box">
                    <p class="quote-text">
                        Some sarees are worn for an occasion. <br />The unforgettable ones
                        become part of the memory.
                    </p>
                    <span class="quote-by">Archana Saree Emporium</span>
                </div>
            </div>
        </section>

        <section class="about-secN">
            <div class="container">
                <div class="news-wrap">
                    <div class="news-photo">
                        <img src="assets/images/home/offer1.jpg" alt="Archana Saree Emporium new arrivals" loading="lazy" />
                    </div>
                    <div class="news-panel">
                        <span class="eyebrow">Stay in the Know</span>
                        <div class="heading">
                            <h3>Be the First to Discover What's New</h3>
                        </div>
                        <p class="news-desc">
                            Sign up for new arrivals, curated collections, styling
                            inspiration and exclusive offers from Archana Saree Emporium.
                        </p>
                        <form class="form news-form" action="#" method="post">
                            <div class="form-group">
                                <input type="email" id="newsEmail" name="email" placeholder=" " required />
                                <label for="newsEmail">Enter your email address</label>
                            </div>
                            <button type="submit" class="btn btn-black">
                                Subscribe <i class="fa-solid fa-arrow-right-long"></i>
                            </button>
                        </form>
                        <p class="news-note">
                            By subscribing, you agree to receive updates and offers from
                            Archana Saree Emporium.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection