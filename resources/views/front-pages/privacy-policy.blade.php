@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/other/other.css') }}" />
@endpush

@section('content')

    <main>
      <section class="common-policies-secA">
        <div class="container-fluid">
          <div class="banner">
            <nav class="breadcrumb" aria-label="Breadcrumb">
              <ol>
                <li>
                  <a href="index.html">Home</a>
                  <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li aria-current="page">Privacy Policy</li>
              </ol>
            </nav>

            <div class="heading">
              <h1>Privacy Policy</h1>
              <p>
                Learn how Archana Saree Emporium collects, uses and protects
                your personal information.
              </p>
            </div>
          </div>
        </div>
      </section>

      <section class="common-policies-secB">
        <div class="container-fluid">
          <div class="website-content">
            <h2>Introduction</h2>
            <p>
              At Archana Saree Emporium, we respect your privacy and are
              committed to protecting your personal information. This Privacy
              Policy explains what data we collect, how we use it and the
              choices you have when you visit our website or shop with us.
            </p>

            <h2>Information We Collect</h2>
            <h3>Information You Provide</h3>
            <p>We collect information that you give us directly, such as:</p>
            <ul>
              <li>Your name, email address and phone number</li>
              <li>Billing and delivery addresses</li>
              <li>Order details, measurements and customisation requests</li>
              <li>Messages you send us through forms, email or WhatsApp</li>
            </ul>
            <h3>Information Collected Automatically</h3>
            <p>
              When you visit our website, we may automatically collect your IP
              address, browser type, device information, pages viewed and the
              time you spent on our website.
            </p>
            <h3>Payment Information</h3>
            <p>
              Payments are processed by secure third-party payment gateways. We
              do not store your full card number, CVV or UPI PIN on our servers.
            </p>

            <h2>How We Use Your Information</h2>
            <p>We use your information to:</p>
            <ul>
              <li>Process and deliver your orders.</li>
              <li>Send order updates, invoices and support replies.</li>
              <li>Manage your account, wishlist and saved addresses.</li>
              <li>
                Share offers, new arrivals and festive collections, where you
                have agreed to receive them.
              </li>
              <li>Improve our website, products and customer service.</li>
              <li>Prevent fraud and keep our website secure.</li>
            </ul>

            <h2>Cookies</h2>
            <p>
              We use cookies and similar technologies to remember your
              preferences, keep items in your bag and understand how visitors
              use our website. You can disable cookies in your browser settings,
              but some parts of the website may not work properly.
            </p>

            <h2>Sharing Your Information</h2>
            <p>
              We do not sell your personal information. We share it only with
              trusted partners who help us run our business, such as:
            </p>
            <ul>
              <li>Courier and logistics partners, to deliver your order</li>
              <li>Payment gateways, to process your payment</li>
              <li>Analytics and marketing tools, to improve our services</li>
              <li>Authorities, where required by law</li>
            </ul>

            <h2>Data Security</h2>
            <p>
              We use reasonable technical and organisational measures to protect
              your information from unauthorised access, loss or misuse.
              However, no method of transmission over the internet is completely
              secure, so we cannot guarantee absolute security.
            </p>

            <h2>Data Retention</h2>
            <p>
              We keep your information only for as long as needed to fulfil your
              orders, meet legal and accounting requirements and resolve
              disputes.
            </p>

            <h2>Your Rights</h2>
            <p>You may at any time:</p>
            <ul>
              <li>
                Ask to view or update the personal data we hold about you.
              </li>
              <li>Ask us to delete your account and personal data.</li>
              <li>Unsubscribe from marketing emails and messages.</li>
            </ul>

            <h2>Children's Privacy</h2>
            <p>
              Our website is not meant for children under 18, and we do not
              knowingly collect personal information from them.
            </p>

            <h2>Changes to This Policy</h2>
            <p>
              We may update this Privacy Policy from time to time. Any changes
              will be posted on this page, and continued use of our website
              means you accept the updated policy.
            </p>

            <h2>Contact Us</h2>
            <p>
              For any privacy-related questions or requests, please contact us:
            </p>
            <ul>
              <li>
                <strong>Email:</strong>
                <a href="mailto:care@archanasaree.com">care@archanasaree.com</a>
              </li>
              <li>
                <strong>Phone:</strong>
                <a href="tel:+919876543210">+91 98765 43210</a>
              </li>
              <li>
                <strong>Address:</strong> Archana Saree Emporium, Chandni Chowk,
                Delhi – 110006
              </li>
            </ul>
          </div>
        </div>
      </section>
    </main>

   
@endsection