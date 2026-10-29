@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/blogs/blogs.css') }}" />
@endpush

@section('content')

    <main>
      <section class="blog-secA">
        <div class="container">
          <ul class="crumb">
            <li><a href="index.html">Home</a></li>
            <li><i class="fa-solid fa-chevron-right"></i></li>
            <li class="current">Blog</li>
          </ul>
          <div class="ban-grid">
            <div class="ban-content">
              <span class="eyebrow">The Archana Journal</span>
              <div class="heading">
                <h1>Stories, Styling &amp; Saree Inspiration</h1>
              </div>
              <p class="ban-desc">
                Draping guides, wedding edits, fabric stories and styling ideas
                from the world of Indian ethnic wear.
              </p>
            </div>
            <div class="ban-visual">
              <div class="ban-photo">
                <img
                  src="assets/images/home/banner5.jpg"
                  alt="Archana Saree Emporium journal"
                />
              </div>
              <span class="ban-tag">Read &amp; Be Inspired</span>
            </div>
          </div>
        </div>
      </section>

      <section class="blog-secB">
        <div class="container">
          <div class="feat-card">
            <a href="blog-detail.html" class="feat-img">
              <img
                src="assets/images/home/offer2.png"
                alt="How to choose the perfect bridal saree"
                loading="lazy"
              />
              <span class="feat-tag">Featured</span>
            </a>
            <div class="feat-content">
              <div class="post-meta">
                <span class="post-date"
                  ><i class="fa-regular fa-calendar"></i
                  ><time datetime="2026-10-22">22 Oct 2026</time></span
                >
                <span class="post-cat">Bridal Edit</span>
              </div>
              <h3>
                <a href="blog-detail.html"
                  >How to Choose the Perfect Bridal Saree for Your Big Day</a
                >
              </h3>
              <p>
                From fabric and colour to zari and drape, here is a simple guide
                to finding a bridal saree that feels like it was made for you.
              </p>
              <a href="blog-detail.html" class="btn btn-primary"
                >Read Article <i class="fa-solid fa-arrow-right-long"></i
              ></a>
            </div>
          </div>
        </div>
      </section>

      <section class="blog-secC">
        <div class="container">
          <div class="sub-head">
            <span class="eyebrow">More to Read</span>
            <div class="heading"><h3>Latest From the Journal</h3></div>
          </div>
          <div class="blog-grid">
            <div class="blog-card">
              <a href="blog-detail.html" class="blog-img">
                <img
                  src="assets/images/home/cat1.png"
                  alt="Banarasi saree styling guide"
                  loading="lazy"
                />
                <span class="blog-cat">Styling</span>
              </a>
              <div class="blog-body">
                <span class="blog-date"
                  ><i class="fa-regular fa-calendar"></i
                  ><time datetime="2026-10-18">18 Oct 2026</time></span
                >
                <h4>
                  <a href="blog-detail.html"
                    >5 Ways to Style a Banarasi Saree for Festive Evenings</a
                  >
                </h4>
                <p>
                  Simple styling ideas to make a classic Banarasi feel fresh,
                  modern and effortless.
                </p>
                <a href="blog-detail.html" class="blog-link"
                  >Read More <i class="fa-solid fa-arrow-right-long"></i
                ></a>
              </div>
            </div>
            <div class="blog-card">
              <a href="blog-detail.html" class="blog-img">
                <img
                  src="assets/images/home/tab2.png"
                  alt="Silk saree care guide"
                  loading="lazy"
                />
                <span class="blog-cat">Saree Care</span>
              </a>
              <div class="blog-body">
                <span class="blog-date"
                  ><i class="fa-regular fa-calendar"></i
                  ><time datetime="2026-10-14">14 Oct 2026</time></span
                >
                <h4>
                  <a href="blog-detail.html"
                    >How to Care for Your Silk Sarees So They Last for Years</a
                  >
                </h4>
                <p>
                  Storage, folding and cleaning tips that protect the weave,
                  zari and colour.
                </p>
                <a href="blog-detail.html" class="blog-link"
                  >Read More <i class="fa-solid fa-arrow-right-long"></i
                ></a>
              </div>
            </div>
            <div class="blog-card">
              <a href="blog-detail.html" class="blog-img">
                <img
                  src="assets/images/home/cat2.png"
                  alt="Lehenga trends"
                  loading="lazy"
                />
                <span class="blog-cat">Trends</span>
              </a>
              <div class="blog-body">
                <span class="blog-date"
                  ><i class="fa-regular fa-calendar"></i
                  ><time datetime="2026-10-09">09 Oct 2026</time></span
                >
                <h4>
                  <a href="blog-detail.html"
                    >Designer Lehenga Trends to Watch This Wedding Season</a
                  >
                </h4>
                <p>
                  Silhouettes, colours and embroidery that are shaping this
                  season's celebrations.
                </p>
                <a href="blog-detail.html" class="blog-link"
                  >Read More <i class="fa-solid fa-arrow-right-long"></i
                ></a>
              </div>
            </div>
            <div class="blog-card">
              <a href="blog-detail.html" class="blog-img">
                <img
                  src="assets/images/home/tab3.png"
                  alt="Saree draping styles"
                  loading="lazy"
                />
                <span class="blog-cat">Draping</span>
              </a>
              <div class="blog-body">
                <span class="blog-date"
                  ><i class="fa-regular fa-calendar"></i
                  ><time datetime="2026-10-04">04 Oct 2026</time></span
                >
                <h4>
                  <a href="blog-detail.html"
                    >A Beginner's Guide to Draping the Perfect Saree Pleats</a
                  >
                </h4>
                <p>
                  Easy steps to get neat pleats and a graceful fall, even if you
                  are new to sarees.
                </p>
                <a href="blog-detail.html" class="blog-link"
                  >Read More <i class="fa-solid fa-arrow-right-long"></i
                ></a>
              </div>
            </div>
            <div class="blog-card">
              <a href="blog-detail.html" class="blog-img">
                <img
                  src="assets/images/home/cat4.png"
                  alt="Kanjivaram saree story"
                  loading="lazy"
                />
                <span class="blog-cat">Heritage</span>
              </a>
              <div class="blog-body">
                <span class="blog-date"
                  ><i class="fa-regular fa-calendar"></i
                  ><time datetime="2026-09-29">29 Sep 2026</time></span
                >
                <h4>
                  <a href="blog-detail.html"
                    >The Story Behind the Kanjivaram: Weaving a Legacy in
                    Silk</a
                  >
                </h4>
                <p>
                  Why this South Indian classic remains a timeless favourite for
                  every occasion.
                </p>
                <a href="blog-detail.html" class="blog-link"
                  >Read More <i class="fa-solid fa-arrow-right-long"></i
                ></a>
              </div>
            </div>
            <div class="blog-card">
              <a href="blog-detail.html" class="blog-img">
                <img
                  src="assets/images/home/tab4.png"
                  alt="Occasion wear guide"
                  loading="lazy"
                />
                <span class="blog-cat">Guides</span>
              </a>
              <div class="blog-body">
                <span class="blog-date"
                  ><i class="fa-regular fa-calendar"></i
                  ><time datetime="2026-09-24">24 Sep 2026</time></span
                >
                <h4>
                  <a href="blog-detail.html"
                    >What to Wear to a Wedding: A Saree Guide for Every Role</a
                  >
                </h4>
                <p>
                  From the bride's family to the guest list, find the right
                  drape for every wedding event.
                </p>
                <a href="blog-detail.html" class="blog-link"
                  >Read More <i class="fa-solid fa-arrow-right-long"></i
                ></a>
              </div>
            </div>
            <div class="blog-card">
              <a href="blog-detail.html" class="blog-img">
                <img
                  src="assets/images/home/cat3.png"
                  alt="Festive party wear"
                  loading="lazy"
                />
                <span class="blog-cat">Festive</span>
              </a>
              <div class="blog-body">
                <span class="blog-date"
                  ><i class="fa-regular fa-calendar"></i
                  ><time datetime="2026-09-19">19 Sep 2026</time></span
                >
                <h4>
                  <a href="blog-detail.html"
                    >Diwali Dressing: Sarees That Sparkle Without Trying Too
                    Hard</a
                  >
                </h4>
                <p>
                  Elegant festive picks in colours and fabrics that glow in
                  candlelight.
                </p>
                <a href="blog-detail.html" class="blog-link"
                  >Read More <i class="fa-solid fa-arrow-right-long"></i
                ></a>
              </div>
            </div>
            <div class="blog-card">
              <a href="blog-detail.html" class="blog-img">
                <img
                  src="assets/images/home/tab1.png"
                  alt="Fabric guide"
                  loading="lazy"
                />
                <span class="blog-cat">Fabric Guide</span>
              </a>
              <div class="blog-body">
                <span class="blog-date"
                  ><i class="fa-regular fa-calendar"></i
                  ><time datetime="2026-09-14">14 Sep 2026</time></span
                >
                <h4>
                  <a href="blog-detail.html"
                    >Organza, Georgette or Chiffon? Choosing the Right Fabric</a
                  >
                </h4>
                <p>
                  A quick comparison of drape, weight and comfort to help you
                  pick with confidence.
                </p>
                <a href="blog-detail.html" class="blog-link"
                  >Read More <i class="fa-solid fa-arrow-right-long"></i
                ></a>
              </div>
            </div>
            <div class="blog-card">
              <a href="blog-detail.html" class="blog-img">
                <img
                  src="assets/images/home/ower2.jpeg"
                  alt="Behind the scenes"
                  loading="lazy"
                />
                <span class="blog-cat">Our Story</span>
              </a>
              <div class="blog-body">
                <span class="blog-date"
                  ><i class="fa-regular fa-calendar"></i
                  ><time datetime="2026-09-08">08 Sep 2026</time></span
                >
                <h4>
                  <a href="blog-detail.html"
                    >Behind the Counter: How We Curate Every Saree We Sell</a
                  >
                </h4>
                <p>
                  A look at the details we check before a saree earns its place
                  in our collection.
                </p>
                <a href="blog-detail.html" class="blog-link"
                  >Read More <i class="fa-solid fa-arrow-right-long"></i
                ></a>
              </div>
            </div>
          </div>
          <ul class="blog-pager">
            <li>
              <a href="#" class="pg-arrow" aria-label="Previous page"
                ><i class="fa-solid fa-arrow-left-long"></i
              ></a>
            </li>
            <li><a href="#" class="active">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li>
              <a href="#" class="pg-arrow" aria-label="Next page"
                ><i class="fa-solid fa-arrow-right-long"></i
              ></a>
            </li>
          </ul>
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
              <a href="product-listing.html" class="btn btn-primary"
                >Shop Sarees</a
              >
              <a href="category-listing.html" class="btn btn-outline-primary"
                >Explore Collections <i class="fa-solid fa-arrow-right-long"></i
              ></a>
            </div>
          </div>
        </div>
      </section>
    </main>

@endsection