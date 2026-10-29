@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/contact/contact.css') }}" />
@endpush

@section('content')

    <main>
      <section class="contact-secA">
        <div class="container">
          <ul class="crumb">
            <li><a href="index.html">Home</a></li>
            <li><i class="fa-solid fa-chevron-right"></i></li>
            <li class="current">Contact Us</li>
          </ul>
          <div class="ban-grid">
            <div class="ban-content">
              <span class="eyebrow">Get in Touch</span>
              <div class="heading">
                <h1>We'd Love to Help You Find Your Perfect Look</h1>
              </div>
              <p class="ban-desc">
                Whether you're looking for a timeless saree, a statement lehenga
                or bridal wear for your special day, our team is here to help
                you choose the right piece.
              </p>
              <div class="ban-btns">
                <a href="tel:+91XXXXXXXXXX" class="btn btn-primary"
                  ><i class="fa-solid fa-phone"></i> Call Now</a
                >
                <a
                  href="https://wa.me/91XXXXXXXXXX"
                  class="btn btn-outline-primary"
                  target="_blank"
                  rel="noopener"
                  ><i class="fa-brands fa-whatsapp"></i> WhatsApp Us</a
                >
              </div>
            </div>
            <div class="ban-visual">
              <div class="ban-photo">
                <img
                  src="assets/images/home/banner5.jpg"
                  alt="Archana Saree Emporium saree collection"
                />
              </div>
              <span class="ban-tag">Personal Assistance</span>
            </div>
          </div>
        </div>
      </section>

      <section class="contact-secB">
        <div class="container">
          <div class="opt-grid">
            <div class="opt-card">
              <span class="opt-ico"><i class="fa-solid fa-phone"></i></span>
              <span class="opt-label">Call Us</span>
              <h4>Speak With Our Team</h4>
              <p>
                Have a question about a product, order or availability? Give us
                a call.
              </p>
              <a href="tel:+91XXXXXXXXXX" class="opt-link"
                >Call Now <i class="fa-solid fa-arrow-right-long"></i
              ></a>
            </div>
            <div class="opt-card">
              <span class="opt-ico"><i class="fa-brands fa-whatsapp"></i></span>
              <span class="opt-label">WhatsApp</span>
              <h4>Chat With Us</h4>
              <p>
                Get quick assistance with product details, availability and
                shopping enquiries.
              </p>
              <a
                href="https://wa.me/91XXXXXXXXXX"
                class="opt-link"
                target="_blank"
                rel="noopener"
                >Chat on WhatsApp <i class="fa-solid fa-arrow-right-long"></i
              ></a>
            </div>
            <div class="opt-card">
              <span class="opt-ico"
                ><i class="fa-solid fa-location-dot"></i
              ></span>
              <span class="opt-label">Visit Our Store</span>
              <h4>Visit Archana Saree Emporium</h4>
              <p>
                Explore our collections in person and let our team help you find
                your perfect look.
              </p>
              <a href="#storeLocation" class="opt-link"
                >Get Directions <i class="fa-solid fa-arrow-right-long"></i
              ></a>
            </div>
            <div class="opt-card">
              <span class="opt-ico"><i class="fa-solid fa-envelope"></i></span>
              <span class="opt-label">Email Us</span>
              <h4>Send an Email</h4>
              <p>
                For detailed enquiries, collaborations or general assistance,
                send us a message.
              </p>
              <a href="mailto:[EMAIL ADDRESS]" class="opt-link"
                >Email Us <i class="fa-solid fa-arrow-right-long"></i
              ></a>
            </div>
          </div>
        </div>
      </section>
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
                <li>
                  <i class="fa-solid fa-phone" aria-hidden="true"></i>
                  <div>
                    <b>Phone</b>
                    <a href="tel:+911145671890">+91 11 4567 1890</a>
                  </div>
                </li>

                <li>
                  <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                  <div>
                    <b>WhatsApp</b>
                    <a
                      href="https://wa.me/919810456789"
                      target="_blank"
                      rel="noopener"
                    >
                      +91 98104 56789
                    </a>
                  </div>
                </li>

                <li>
                  <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                  <div>
                    <b>Email</b>
                    <a href="mailto:hello@archanasareeemporium.com">
                      hello@archanasareeemporium.com
                    </a>
                  </div>
                </li>

                <li>
                  <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                  <div>
                    <b>Store Address</b>
                    <span>
                      1842, Kucha Natwa, Chandni Chowk, Delhi – 110006
                    </span>
                  </div>
                </li>

                <li>
                  <i class="fa-regular fa-clock" aria-hidden="true"></i>
                  <div>
                    <b>Business Hours</b>
                    <span>
                      Monday – Saturday: 10:30 AM – 8:30 PM<br />
                      Sunday: 11:00 AM – 7:00 PM
                    </span>
                  </div>
                </li>
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

              <form
                id="contactForm"
                class="form ct-form"
                action=""
                method="post"
                novalidate
              >
                <div class="ct-fields">
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control"
                      id="cName"
                      name="name"
                      placeholder=" "
                      autocomplete="name"
                      required
                    />
                    <label for="cName">Full Name *</label>
                    <span class="error" hidden></span>
                  </div>

                  <div class="form-group">
                    <input
                      type="tel"
                      class="form-control"
                      id="cPhone"
                      name="phone"
                      placeholder=" "
                      autocomplete="tel"
                      required
                    />
                    <label for="cPhone">Phone Number *</label>
                    <span class="error" hidden></span>
                  </div>

                  <div class="form-group">
                    <input
                      type="email"
                      class="form-control"
                      id="cEmail"
                      name="email"
                      placeholder=" "
                      autocomplete="email"
                      required
                    />
                    <label for="cEmail">Email Address *</label>
                    <span class="error" hidden></span>
                  </div>

                  <div class="form-group">
                    <select class="form-control" id="cType" name="type">
                      <option value="">Enquiry Type</option>
                      <option value="Saree Enquiry">Saree Enquiry</option>
                      <option value="Lehenga Enquiry">Lehenga Enquiry</option>
                      <option value="Bridal Wear">Bridal Wear</option>
                      <option value="Product Availability">
                        Product Availability
                      </option>
                      <option value="Order Assistance">Order Assistance</option>
                      <option value="Store Visit">Store Visit</option>
                      <option value="General Enquiry">General Enquiry</option>
                    </select>
                  </div>

                  <div class="form-group ct-full">
                    <textarea
                      class="form-control"
                      id="cMessage"
                      name="message"
                      placeholder=" "
                      required
                    ></textarea>
                    <label for="cMessage">
                      Tell us what you're looking for... *
                    </label>
                    <span class="error" hidden></span>
                  </div>
                </div>

                <p class="ct-status" id="ctStatus" role="alert" hidden></p>

                <div class="ct-actions">
                  <button type="submit" class="btn btn-primary">
                    Send Enquiry
                    <i
                      class="fa-solid fa-arrow-right-long"
                      aria-hidden="true"
                    ></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>

      <section class="contact-secD" id="storeLocation">
        <div class="container">
          <div class="loc-grid">
            <div class="loc-info">
              <span class="eyebrow">Visit Us</span>

              <div class="heading">
                <h3>Come Visit Archana Saree Emporium</h3>
              </div>

              <p class="loc-desc">
                Prefer to see the collection in person? Visit our store and
                explore our sarees, lehengas and bridal collections with our
                team.
              </p>

              <ul class="loc-meta">
                <li>
                  <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                  <div>
                    <b>Store Address</b>
                    <span>
                      1842, Kucha Natwa, Chandni Chowk, Delhi – 110006
                    </span>
                  </div>
                </li>

                <li>
                  <i class="fa-solid fa-phone" aria-hidden="true"></i>
                  <div>
                    <b>Phone</b>
                    <span>+91 11 4567 1890</span>
                  </div>
                </li>

                <li>
                  <i class="fa-regular fa-clock" aria-hidden="true"></i>
                  <div>
                    <b>Opening Hours</b>
                    <span>
                      Monday – Saturday: 10:30 AM – 8:30 PM<br />
                      Sunday: 11:00 AM – 7:00 PM
                    </span>
                  </div>
                </li>
              </ul>

              <a
                href="https://www.google.com/maps/dir/?api=1&destination=Kucha+Natwa,+Chandni+Chowk,+Delhi+110006"
                class="btn btn-primary"
                target="_blank"
                rel="noopener"
              >
                Get Directions
                <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
              </a>
            </div>

            <div class="loc-map">
              <iframe
                title="Archana Saree Emporium location"
                src="https://www.google.com/maps?q=Kucha+Natwa,+Chandni+Chowk,+Delhi+110006&output=embed"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen
              ></iframe>
            </div>
          </div>
        </div>
      </section>

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
              <a
                href="https://wa.me/91XXXXXXXXXX"
                class="btn btn-primary"
                target="_blank"
                rel="noopener"
                ><i class="fa-brands fa-whatsapp"></i> WhatsApp Us</a
              >
              <a href="tel:+91XXXXXXXXXX" class="btn btn-outline-primary"
                ><i class="fa-solid fa-phone"></i> Call Us</a
              >
            </div>
          </div>
        </div>
      </section>
    </main>

@endsection   
