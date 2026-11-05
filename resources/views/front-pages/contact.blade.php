@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/sass/contact/contact.css') }}" />
@endpush

@section('content')
  @php
    $siteName = $general->site_name ?: config('app.name');

    // phone for tel: links (digits and +)
    $telNum = preg_replace('/[^\d+]/', '', (string) $general->phone);

    // WhatsApp: digits only, add 91 to a 10 digit number
    $waNum = preg_replace('/\D/', '', (string) $general->whatsapp);
    if (strlen($waNum) === 10) {
      $waNum = '91' . $waNum;
    }

    $email = $general->support_email ?: $general->admin_email;
    $address = $general->business_address;
    $hours = $general->business_hours;

    // google_map_url must be the embed src; if empty, build one from the address
    $mapSrc = $general->google_map_url
      ?: ($address ? 'https://www.google.com/maps?q=' . urlencode($address) . '&output=embed' : null);
    $dirUrl = $address
      ? 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($address)
      : null;
  @endphp

  <main>
    
    <section class="contact-secA">
      <div class="container">
        <ul class="crumb">
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><i class="fa-solid fa-chevron-right"></i></li>
          <li class="current">Contact Us</li>
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
            @if ($telNum || $waNum)
              <div class="ban-btns">
                @if ($telNum)
                  <a href="tel:{{ $telNum }}" class="btn btn-primary">
                    <i class="fa-solid fa-phone"></i> Call Now
                  </a>
                @endif
                @if ($waNum)
                  <a href="https://wa.me/{{ $waNum }}" class="btn btn-outline-primary" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp Us
                  </a>
                @endif
              </div>
            @endif
          </div>
          <div class="ban-visual">
            <div class="ban-photo">
              <img src="{{ $hero->image_url }}" alt="{{ $siteName }} saree collection" />
            </div>
            @if (filled($hero->tag))
              <span class="ban-tag">{{ $hero->tag }}</span>
            @endif
          </div>
        </div>
      </div>
    </section>

    {{-- ================= Contact option cards ================= --}}
    <section class="contact-secB">
      <div class="container">
        <div class="opt-grid">

          @if ($telNum)
            <div class="opt-card">
              <span class="opt-ico"><i class="fa-solid fa-phone"></i></span>
              <span class="opt-label">Call Us</span>
              <h4>Speak With Our Team</h4>
              <p>
                Have a question about a product, order or availability? Give us
                a call.
              </p>
              <a href="tel:{{ $telNum }}" class="opt-link">
                Call Now <i class="fa-solid fa-arrow-right-long"></i>
              </a>
            </div>
          @endif

          @if ($waNum)
            <div class="opt-card">
              <span class="opt-ico"><i class="fa-brands fa-whatsapp"></i></span>
              <span class="opt-label">WhatsApp</span>
              <h4>Chat With Us</h4>
              <p>
                Get quick assistance with product details, availability and
                shopping enquiries.
              </p>
              <a href="https://wa.me/{{ $waNum }}" class="opt-link" target="_blank" rel="noopener">
                Chat on WhatsApp <i class="fa-solid fa-arrow-right-long"></i>
              </a>
            </div>
          @endif

          @if ($address)
            <div class="opt-card">
              <span class="opt-ico"><i class="fa-solid fa-location-dot"></i></span>
              <span class="opt-label">Visit Our Store</span>
              <h4>Visit {{ $siteName }}</h4>
              <p>
                Explore our collections in person and let our team help you find
                your perfect look.
              </p>
              <a href="#storeLocation" class="opt-link">
                Get Directions <i class="fa-solid fa-arrow-right-long"></i>
              </a>
            </div>
          @endif

          @if ($email)
            <div class="opt-card">
              <span class="opt-ico"><i class="fa-solid fa-envelope"></i></span>
              <span class="opt-label">Email Us</span>
              <h4>Send an Email</h4>
              <p>
                For detailed enquiries, collaborations or general assistance,
                send us a message.
              </p>
              <a href="mailto:{{ $email }}" class="opt-link">
                Email Us <i class="fa-solid fa-arrow-right-long"></i>
              </a>
            </div>
          @endif

        </div>
      </div>
    </section>

    {{-- ================= Details + enquiry form ================= --}}
    <section class="contact-secC">
      <div class="container">
        <div class="ct-layout">
          <div class="ct-info">
            <span class="eyebrow">Let's Connect</span>

            <div class="heading">
              <h3>Have Something in Mind?</h3>
            </div>

            <p class="ct-desc">
              From choosing the right saree for a celebration to finding a
              bridal ensemble that feels truly yours, our team is happy to
              assist you.
            </p>

            <ul class="ct-list">
              @if ($general->phone)
                <li>
                  <i class="fa-solid fa-phone" aria-hidden="true"></i>
                  <div>
                    <b>Phone</b>
                    <a href="tel:{{ $telNum }}">{{ $general->phone }}</a>
                  </div>
                </li>
              @endif

              @if ($waNum)
                <li>
                  <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                  <div>
                    <b>WhatsApp</b>
                    <a href="https://wa.me/{{ $waNum }}" target="_blank" rel="noopener">
                      {{ $general->whatsapp }}
                    </a>
                  </div>
                </li>
              @endif

              @if ($email)
                <li>
                  <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                  <div>
                    <b>Email</b>
                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                  </div>
                </li>
              @endif

              @if ($address)
                <li>
                  <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                  <div>
                    <b>Store Address</b>
                    <span>{!! nl2br(e($address)) !!}</span>
                  </div>
                </li>
              @endif

              @if ($hours)
                <li>
                  <i class="fa-regular fa-clock" aria-hidden="true"></i>
                  <div>
                    <b>Business Hours</b>
                    <span>{!! nl2br(e($hours)) !!}</span>
                  </div>
                </li>
              @endif
            </ul>
          </div>

          <div class="ct-form-card">
            <div class="ct-form-head">
              <h4>Send Us an Enquiry</h4>
              <p>
                Tell us what you're looking for and our team will get back to
                you.
              </p>
            </div>

            <form id="contactForm" class="form ct-form" action="{{ route('contact.submit') }}" method="post" novalidate>
              @csrf

              {{-- honeypot: hidden from real users, bots fill it --}}
              <input type="text" name="website" tabindex="-1" autocomplete="off"
                style="position:absolute;left:-9999px;opacity:0" aria-hidden="true" />

              <div class="ct-fields">
                <div class="form-group">
                  <input type="text" class="form-control" id="cName" name="name" placeholder=" " autocomplete="name"
                    required />
                  <label for="cName">Full Name *</label>
                  <span class="error" hidden></span>
                </div>

                <div class="form-group">
                  <input type="tel" class="form-control" id="cPhone" name="phone" placeholder=" " autocomplete="tel"
                    required />
                  <label for="cPhone">Phone Number *</label>
                  <span class="error" hidden></span>
                </div>

                <div class="form-group">
                  <input type="email" class="form-control" id="cEmail" name="email" placeholder=" " autocomplete="email"
                    required />
                  <label for="cEmail">Email Address *</label>
                  <span class="error" hidden></span>
                </div>

                <div class="form-group">
                  <select class="form-control" id="cType" name="type">
                    <option value="">Enquiry Type</option>
                    @foreach ($enquiryTypes as $t)
                      <option value="{{ $t }}">{{ $t }}</option>
                    @endforeach
                  </select>
                  <span class="error" hidden></span>
                </div>

                <div class="form-group ct-full">
                  <textarea class="form-control" id="cMessage" name="message" placeholder=" " required></textarea>
                  <label for="cMessage">Tell us what you're looking for... *</label>
                  <span class="error" hidden></span>
                </div>
              </div>

              <p class="ct-status" id="ctStatus" role="alert" hidden></p>

              <div class="ct-actions">
                <button type="submit" class="btn btn-primary">
                  Send Enquiry
                  <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    {{-- ================= Store location ================= --}}
    @if ($address || $mapSrc)
      <section class="contact-secD" id="storeLocation">
        <div class="container">
          <div class="loc-grid">
            <div class="loc-info">
              <span class="eyebrow">Visit Us</span>

              <div class="heading">
                <h3>Come Visit {{ $siteName }}</h3>
              </div>

              <p class="loc-desc">
                Prefer to see the collection in person? Visit our store and
                explore our sarees, lehengas and bridal collections with our
                team.
              </p>

              <ul class="loc-meta">
                @if ($address)
                  <li>
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                    <div>
                      <b>Store Address</b>
                      <span>{!! nl2br(e($address)) !!}</span>
                    </div>
                  </li>
                @endif

                @if ($general->phone)
                  <li>
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    <div>
                      <b>Phone</b>
                      <span>{{ $general->phone }}</span>
                    </div>
                  </li>
                @endif

                @if ($hours)
                  <li>
                    <i class="fa-regular fa-clock" aria-hidden="true"></i>
                    <div>
                      <b>Opening Hours</b>
                      <span>{!! nl2br(e($hours)) !!}</span>
                    </div>
                  </li>
                @endif
              </ul>

              @if ($dirUrl)
                <a href="{{ $dirUrl }}" class="btn btn-primary" target="_blank" rel="noopener">
                  Get Directions
                  <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                </a>
              @endif
            </div>

            @if ($mapSrc)
              <div class="loc-map">
                <iframe title="{{ $siteName }} location" src="{{ $mapSrc }}" loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
              </div>
            @endif
          </div>
        </div>
      </section>
    @endif

    {{-- ================= Need help ================= --}}
    <section class="contact-secE">
      <div class="container">
        <div class="help-box">
          <div class="help-content">
            <span class="eyebrow">Need Help?</span>
            <div class="heading">
              <h3>We're Here to Make Shopping Easier</h3>
            </div>
            <p>
              Have questions about a saree, lehenga, bridal outfit,
              availability or your order? Reach out to us and our team will be
              happy to assist.
            </p>
          </div>
          <div class="help-btns">
            @if ($waNum)
              <a href="https://wa.me/{{ $waNum }}" class="btn btn-primary" target="_blank" rel="noopener">
                <i class="fa-brands fa-whatsapp"></i> WhatsApp Us
              </a>
            @endif
            @if ($telNum)
              <a href="tel:{{ $telNum }}" class="btn btn-outline-primary">
                <i class="fa-solid fa-phone"></i> Call Us
              </a>
            @endif
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection

@push('scripts')
  <script>
    (function () {
      var f = document.getElementById('contactForm'),
        st = document.getElementById('ctStatus');
      if (!f) return;
      var btn = f.querySelector('button[type=submit]');

      function showStatus(msg, ok) {
        st.textContent = msg;
        st.hidden = false;
        st.style.color = ok ? '#1b7a4b' : '#b22222';
      }

      f.addEventListener('submit', function (e) {
        e.preventDefault();

        f.querySelectorAll('.error').forEach(function (s) {
          s.hidden = true;
          s.textContent = '';
        });
        st.hidden = true;
        btn.disabled = true;

        fetch(f.action, {
          method: 'POST',
          headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
          body: new FormData(f)
        })
          .then(function (r) {
            return r.json().then(function (j) { return { status: r.status, body: j }; });
          })
          .then(function (res) {
            if (res.status === 422) {
              Object.keys(res.body.errors || {}).forEach(function (k) {
                var field = f.querySelector('[name="' + k + '"]');
                var group = field && field.closest('.form-group');
                var span = group && group.querySelector('.error');
                if (span) {
                  span.textContent = res.body.errors[k][0];
                  span.hidden = false;
                }
              });
              showStatus('Please correct the highlighted fields.', false);
            } else if (res.status >= 200 && res.status < 300) {
              f.reset();
              showStatus(res.body.message, true);
            } else {
              showStatus(
                res.status === 429
                  ? 'Too many attempts. Please try again in a minute.'
                  : 'Something went wrong. Please try again.',
                false
              );
            }
          })
          .catch(function () {
            showStatus('Network error. Please try again.', false);
          })
          .finally(function () {
            btn.disabled = false;
          });
      });
    })();
  </script>
@endpush