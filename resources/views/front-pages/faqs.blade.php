@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/faqs/faqs.css') }}" />
@endpush

@section('content')

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
              <span class="eyebrow">Help &amp; Information</span>
              <div class="heading">
                <h1>Frequently Asked Questions</h1>
              </div>
              <p class="ban-desc">
                Find answers to common questions about our sarees, lehengas,
                bridal collections, orders, payments, delivery and shopping
                experience.
              </p>
            </div>
            <div class="ban-visual">
              <div class="ban-photo">
                <img
                  src="assets/images/home/banner5.jpg"
                  alt="Archana Saree Emporium saree collection"
                />
              </div>
              <span class="ban-tag">Here to Help</span>
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

      <section class="faq-secC">
        <div class="container">
          <div class="faq-layout">
            <ul class="tab-nav">
              <li class="active" data-tab="1">
                <span class="tab-ico"
                  ><i class="fa-solid fa-bag-shopping"></i
                ></span>
                <span class="tab-txt">Shopping &amp; Collections</span>
              </li>
              <li data-tab="2">
                <span class="tab-ico"
                  ><i class="fa-solid fa-ruler-combined"></i
                ></span>
                <span class="tab-txt">Product &amp; Size</span>
              </li>
              <li data-tab="3">
                <span class="tab-ico"
                  ><i class="fa-solid fa-credit-card"></i
                ></span>
                <span class="tab-txt">Orders &amp; Payments</span>
              </li>
              <li data-tab="4">
                <span class="tab-ico"
                  ><i class="fa-solid fa-truck-fast"></i
                ></span>
                <span class="tab-txt">Shipping &amp; Delivery</span>
              </li>
              <li data-tab="5">
                <span class="tab-ico"
                  ><i class="fa-solid fa-rotate-left"></i
                ></span>
                <span class="tab-txt">Returns &amp; Exchanges</span>
              </li>
              <li data-tab="6">
                <span class="tab-ico"><i class="fa-solid fa-store"></i></span>
                <span class="tab-txt">Store &amp; Support</span>
              </li>
            </ul>

            <div class="tab-nav-content">
              <div class="tabs active" data-tab="1">
                <div class="accordion-wrapper">
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>
                        What collections can I shop at Archana Saree Emporium?
                      </h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Explore our curated collection of premium sarees,
                        designer lehengas, bridal wear and occasion-ready
                        styles. Our collections are designed for weddings,
                        festive celebrations, parties and special moments.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>How do I choose the right saree for an occasion?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Consider the occasion, fabric, colour, embroidery and
                        overall styling you prefer. For weddings and festive
                        celebrations, silk, Banarasi and richly detailed sarees
                        are popular choices, while lighter fabrics and elegant
                        drapes work beautifully for parties and intimate
                        occasions.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>Do you offer bridal sarees and wedding wear?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Yes. Our bridal and wedding collections feature
                        statement sarees and traditional occasion wear designed
                        for memorable celebrations. Explore the bridal
                        collection or contact our team for assistance in finding
                        the right style.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>
                        Do you have sarees for parties and festive occasions?
                      </h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Yes. Our collection includes elegant sarees suited for
                        festive gatherings, parties, receptions and special
                        occasions, with a variety of fabrics, colours and
                        embellishment styles.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>Do you also offer designer lehengas?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Yes. We offer designer lehengas and statement occasion
                        wear suitable for weddings, receptions, engagements,
                        festive celebrations and other special occasions.
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tabs" data-tab="2">
                <div class="accordion-wrapper">
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>
                        How can I check the details of a saree or lehenga before
                        ordering?
                      </h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Open the product page to view the available images,
                        fabric or material details, colour information, product
                        description, pricing, offers and other available
                        specifications before placing your order.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>
                        How do I choose the right size for a lehenga or other
                        fitted outfit?
                      </h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Check the size information provided on the product page
                        before ordering. If you need help understanding
                        measurements or choosing between sizes, contact our team
                        before placing your order.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>
                        Will the colour of the product look exactly the same as
                        shown online?
                      </h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        We make every effort to display product colours as
                        accurately as possible. However, slight variations may
                        occur due to photography, lighting and individual screen
                        settings.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>
                        Can I ask about product availability before ordering?
                      </h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Yes. If you want to confirm availability, colour options
                        or product details before purchasing, contact our team
                        through the available call or WhatsApp options.
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tabs" data-tab="3">
                <div class="accordion-wrapper">
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>How can I place an order?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Select the product you want, choose the available
                        options where applicable, add it to your bag and proceed
                        through checkout to complete your purchase.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>What payment methods are available?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Available payment methods will be displayed during
                        checkout. Please review the payment options shown for
                        your order before completing the purchase.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>Can I cancel my order after placing it?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Order cancellation depends on the order status and
                        applicable store policy. If you need to cancel an order,
                        contact our customer support team as soon as possible
                        with your order details.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>How can I get help with my order?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Contact our team with your order number and the details
                        of your query. We can assist with order-related
                        questions, product information and available delivery or
                        support updates.
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tabs" data-tab="4">
                <div class="accordion-wrapper">
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>How long will my order take to arrive?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Delivery time can vary depending on your location,
                        product availability and the shipping method used. The
                        applicable delivery information will be provided during
                        the ordering process.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>Can I track my order?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        If tracking is available for your shipment, tracking
                        details will be shared once your order has been
                        dispatched. Use the provided tracking information to
                        follow your shipment.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>Do you deliver across India?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Delivery availability depends on the serviceable
                        location and the shipping options available at checkout.
                        Enter your delivery details during checkout to confirm
                        availability.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>What should I do if my order is delayed?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        If your order has not arrived within the expected
                        delivery period, contact our support team with your
                        order number so we can help check the latest available
                        shipment information.
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tabs" data-tab="5">
                <div class="accordion-wrapper">
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>Can I return or exchange a product?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Returns and exchanges are subject to the applicable
                        product and store policy. Please review the Returns
                        &amp; Exchanges policy for eligibility, timelines,
                        product conditions and exclusions before raising a
                        request.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>
                        What should I do if I receive a damaged or incorrect
                        product?
                      </h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Contact our support team as soon as possible after
                        receiving the order and provide your order details along
                        with the required product photographs or information.
                        Our team will guide you through the next steps according
                        to the applicable policy.
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tabs" data-tab="6">
                <div class="accordion-wrapper">
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>Can I visit Archana Saree Emporium in person?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Yes. If you prefer to explore the collection in person,
                        you can visit our store during business hours. Please
                        use the <a href="contact.html">Contact page</a> for the
                        latest store address, opening hours and directions.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>Can I contact you on WhatsApp before buying?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        Yes. WhatsApp is a convenient way to ask about product
                        availability, colours, sizes, styling options and
                        general shopping queries before placing your order.
                      </p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <div class="accordion-header">
                      <h4>How can I contact Archana Saree Emporium?</h4>
                      <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                      <p>
                        You can contact our team through phone, WhatsApp, email
                        or by visiting the store. Please visit the
                        <a href="contact.html">Contact page</a> for the
                        available contact details and store information.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="faq-secD">
        <div class="container">
          <div class="help-box">
            <div class="help-content">
              <span class="eyebrow">Still Have a Question?</span>
              <div class="heading"><h3>We're Here to Help</h3></div>
              <p>
                Couldn't find the answer you were looking for? Speak with our
                team and we'll be happy to help you with product details,
                availability, orders or your next occasion look.
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
