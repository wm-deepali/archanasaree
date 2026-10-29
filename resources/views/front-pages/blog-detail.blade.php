@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/blog-detail/blog-detail.css') }}" />
@endpush

@section('content')

    <main>
      <section class="blogd-secA">
        <div class="container">
          <ul class="crumb">
            <li><a href="index.html">Home</a></li>
            <li><i class="fa-solid fa-chevron-right"></i></li>
            <li><a href="blog.html">Blog</a></li>
            <li><i class="fa-solid fa-chevron-right"></i></li>
            <li class="current">Bridal Saree Guide</li>
          </ul>
          <div class="ban-grid">
            <div class="ban-content">
              <div class="post-meta">
                <span class="post-cat">Bridal Edit</span>
                <span class="post-date"
                  ><i class="fa-regular fa-calendar"></i
                  ><time datetime="2026-10-22">22 Oct 2026</time></span
                >
                <span class="post-time"
                  ><i class="fa-regular fa-clock"></i>6 min read</span
                >
              </div>
              <div class="heading">
                <h1>How to Choose the Perfect Bridal Saree for Your Big Day</h1>
              </div>
              <p class="ban-desc">
                From fabric and colour to zari and drape, a simple guide to
                finding a bridal saree that feels like it was made for you.
              </p>
              <div class="ban-by">
                <span class="by-avatar"
                  ><i class="fa-regular fa-user"></i
                ></span>
                <div>
                  <small>Written by</small>
                  <b>Archana Style Team</b>
                </div>
              </div>
            </div>
            <div class="ban-visual">
              <div class="ban-photo">
                <img
                  src="assets/images/home/offer2.png"
                  alt="Bridal saree guide"
                />
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
              <p>
                A bridal saree is chosen once and remembered for a lifetime.
                Here is a <strong>simple checklist</strong> to help you pick the
                right one before you order.
              </p>

              <h2>1. Start with the occasion</h2>
              <p>
                A wedding ceremony, a reception and an engagement each call for
                a different look. Decide the event first, then the colour and
                fabric will follow naturally. Explore our
                <a href="category-listing.html">bridal collection</a> for ideas.
              </p>

              <h2>2. Pick a fabric that suits you</h2>
              <p>
                Different fabrics drape and feel different. Think about
                <em>how long you will wear it</em> and the season of the
                wedding.
              </p>
              <ul>
                <li>
                  <strong>Kanjivaram silk:</strong> rich, structured and long
                  lasting.
                </li>
                <li>
                  <strong>Banarasi:</strong> fine zari work with a regal glow.
                </li>
                <li>
                  <strong>Organza:</strong> light, airy and graceful in warm
                  weather.
                </li>
              </ul>

              <h2>3. Check the details that matter</h2>
              <p>
                Small things make a big difference on the day. Look at these
                points before you decide:
              </p>
              <ol>
                <li>Weave that is even, dense and true to its tradition.</li>
                <li>Zari that glows warmly and is never harsh or heavy.</li>
                <li>
                  Embroidery that is fine, secure and thoughtfully placed.
                </li>
                <li>A drape that falls well and holds its pleats.</li>
              </ol>

              <blockquote>
                The best bridal saree is the one that feels like you the moment
                you drape it.
              </blockquote>

              <h3>Keep comfort in the picture</h3>
              <p>
                You will wear it for hours, so choose a weight and finish that
                feel comfortable. Not sure what suits you? Reach us through the
                <a href="contact.html">contact page</a> and our team will help.
              </p>
            </div>

            <div class="blogd-foot">
              <ul class="blogd-tags" aria-label="Tags">
                <li><a href="javascript:void(0);">Bridal Wear</a></li>
                <li><a href="javascript:void(0);">Silk Sarees</a></li>
                <li><a href="javascript:void(0);">Buying Guide</a></li>
              </ul>
              <div class="blogd-share">
                <span>Share:</span>
                <a href="javascript:void(0);" aria-label="Share on Facebook"
                  ><i class="fa-brands fa-facebook-f"></i
                ></a>
                <a href="javascript:void(0);" aria-label="Share on X"
                  ><i class="fa-brands fa-x-twitter"></i
                ></a>
                <a href="javascript:void(0);" aria-label="Share on WhatsApp"
                  ><i class="fa-brands fa-whatsapp"></i
                ></a>
                <button type="button" class="copyLink" aria-label="Copy link">
                  <i class="fa-solid fa-link"></i>
                </button>
              </div>
            </div>

            <div class="blogd-author">
              <span class="blogd-avatar"
                ><i class="fa-regular fa-user"></i
              ></span>
              <div>
                <small>Written by</small>
                <h4>Archana Style Team</h4>
                <p>
                  We write simple styling and buying guides to help you find the
                  right drape for every occasion.
                </p>
              </div>
            </div>
          </article>
        </div>
      </section>

      <section class="blogd-secC">
        <div class="container">
          <div class="sub-head">
            <span class="eyebrow">Keep Reading</span>
            <div class="heading"><h3>Related Articles</h3></div>
          </div>
          <div class="swiper-wrap">
            <div
              class="swiper thirdSilder"
              data-mob="1.2"
              data-sm="2"
              data-lg="3"
              data-xl="4"
            >
              <div class="swiper-wrapper">
                <div class="swiper-slide">
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
                          >5 Ways to Style a Banarasi Saree for Festive
                          Evenings</a
                        >
                      </h4>
                      <p>
                        Simple styling ideas to make a classic Banarasi feel
                        fresh, modern and effortless.
                      </p>
                      <a href="blog-detail.html" class="blog-link"
                        >Read More <i class="fa-solid fa-arrow-right-long"></i
                      ></a>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
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
                          >How to Care for Your Silk Sarees So They Last for
                          Years</a
                        >
                      </h4>
                      <p>
                        Storage, folding and cleaning tips that protect the
                        weave, zari and colour.
                      </p>
                      <a href="blog-detail.html" class="blog-link"
                        >Read More <i class="fa-solid fa-arrow-right-long"></i
                      ></a>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
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
                          >Designer Lehenga Trends to Watch This Wedding
                          Season</a
                        >
                      </h4>
                      <p>
                        Silhouettes, colours and embroidery that are shaping
                        this season's celebrations.
                      </p>
                      <a href="blog-detail.html" class="blog-link"
                        >Read More <i class="fa-solid fa-arrow-right-long"></i
                      ></a>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
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
                          >A Beginner's Guide to Draping the Perfect Saree
                          Pleats</a
                        >
                      </h4>
                      <p>
                        Easy steps to get neat pleats and a graceful fall, even
                        if you are new to sarees.
                      </p>
                      <a href="blog-detail.html" class="blog-link"
                        >Read More <i class="fa-solid fa-arrow-right-long"></i
                      ></a>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
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
                        Why this South Indian classic remains a timeless
                        favourite for every occasion.
                      </p>
                      <a href="blog-detail.html" class="blog-link"
                        >Read More <i class="fa-solid fa-arrow-right-long"></i
                      ></a>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
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
                          >What to Wear to a Wedding: A Saree Guide for Every
                          Role</a
                        >
                      </h4>
                      <p>
                        From the bride's family to the guest list, find the
                        right drape for every wedding event.
                      </p>
                      <a href="blog-detail.html" class="blog-link"
                        >Read More <i class="fa-solid fa-arrow-right-long"></i
                      ></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-group">
              <button
                type="button"
                class="btn-prev"
                aria-label="Previous slide"
              >
                <i class="fa-solid fa-arrow-right"></i>
              </button>
              <button type="button" class="btn-next" aria-label="Next slide">
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>
        </div>
      </section>
    </main>

@endsection