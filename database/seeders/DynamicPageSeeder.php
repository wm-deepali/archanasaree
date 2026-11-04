<?php

namespace Database\Seeders;

use App\Models\DynamicPage;
use Illuminate\Database\Seeder;

class DynamicPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [

            [
                'slug' => 'privacy-policy',
                'heading' => 'Privacy Policy',
                'short_description' => 'How [[site_name]] collects, uses and protects your personal information.',
                'meta_title' => 'Privacy Policy | [[site_name]]',
                'meta_description' => 'Read how we collect, use and protect your personal information when you shop with us.',
                'content' => <<<'HTML'
<p>At <strong>[[site_name]]</strong>, we respect your privacy. This policy explains what information we collect, how we use it and the choices you have.</p>

<h3>Information We Collect</h3>
<ul>
  <li>Name, email address, mobile number and shipping/billing address when you register or place an order.</li>
  <li>Order history, wishlist and cart activity.</li>
  <li>Device and browsing information such as IP address, browser type and pages visited.</li>
</ul>

<h3>How We Use Your Information</h3>
<ul>
  <li>To process and deliver your orders and send order updates.</li>
  <li>To provide customer support and respond to your queries.</li>
  <li>To improve our website, products and services.</li>
  <li>To send offers and updates, only where you have agreed to receive them.</li>
</ul>

<h3>Payments</h3>
<p>Payments are processed through secure third-party payment gateways. We do not store your card, UPI or net-banking details on our servers.</p>

<h3>Sharing of Information</h3>
<p>We do not sell your personal information. We share it only with trusted partners such as courier companies and payment gateways, and only to the extent needed to fulfil your order, or where required by law.</p>

<h3>Cookies</h3>
<p>We use cookies to keep your cart, remember your preferences and understand how visitors use our website. You can disable cookies in your browser settings, though some features may not work properly.</p>

<h3>Your Rights</h3>
<p>You may request access to, correction of or deletion of your personal information at any time by contacting us.</p>

<h3>Contact Us</h3>
<p>Email: [[email]]<br>Phone: [[phone]]<br>Address: [[address]]</p>
HTML,
            ],

            [
                'slug' => 'terms-conditions',
                'heading' => 'Terms & Conditions',
                'short_description' => 'The terms that apply when you browse or buy from [[site_name]].',
                'meta_title' => 'Terms & Conditions | [[site_name]]',
                'meta_description' => 'Please read the terms and conditions that apply to the use of our website and purchases.',
                'content' => <<<'HTML'
<p>Welcome to <strong>[[site_name]]</strong>. By using this website or placing an order, you agree to the following terms.</p>

<h3>General</h3>
<p>You must be at least 18 years old, or use the website under the supervision of a parent or guardian. We may update these terms at any time, and changes apply from the date they are published.</p>

<h3>Products and Pricing</h3>
<ul>
  <li>We try to display colours, images and descriptions as accurately as possible. Slight variations may occur due to screen settings and photography.</li>
  <li>All prices are in Indian Rupees (INR) and may change without prior notice.</li>
  <li>We reserve the right to cancel an order in case of a pricing or stock error, with a full refund of any amount paid.</li>
</ul>

<h3>Orders and Payments</h3>
<p>An order is confirmed only after successful payment, or confirmation in the case of Cash on Delivery. We may cancel or refuse any order that appears fraudulent or violates these terms.</p>

<h3>Intellectual Property</h3>
<p>All content on this website, including logos, images, designs and text, belongs to [[site_name]] and may not be copied or used without written permission.</p>

<h3>Limitation of Liability</h3>
<p>To the extent permitted by law, [[site_name]] is not liable for indirect or consequential losses arising from the use of this website or our products.</p>

<h3>Governing Law</h3>
<p>These terms are governed by the laws of India. Any dispute is subject to the jurisdiction of the courts at our registered business location.</p>

<h3>Contact Us</h3>
<p>Email: [[email]]<br>Phone: [[phone]]<br>Address: [[address]]</p>
HTML,
            ],

            [
                'slug' => 'shipping-policy',
                'heading' => 'Shipping Policy',
                'short_description' => 'Delivery areas, timelines and charges for your [[site_name]] orders.',
                'meta_title' => 'Shipping Policy | [[site_name]]',
                'meta_description' => 'Learn about our delivery areas, shipping timelines and charges.',
                'content' => <<<'HTML'
<p><strong>[[site_name]]</strong> delivers across India through trusted courier partners.</p>

<h3>Processing Time</h3>
<p>Orders are usually processed within 1–3 business days. Made-to-order or customised items may take longer, and we will inform you in that case.</p>

<h3>Delivery Time</h3>
<ul>
  <li>Metro cities: 3–5 business days</li>
  <li>Other cities and towns: 5–8 business days</li>
  <li>Remote locations: up to 10 business days</li>
</ul>
<p>Delivery timelines are estimates and may be affected by weather, festivals or courier delays.</p>

<h3>Shipping Charges</h3>
<p>Shipping charges, if any, are shown at checkout before you pay.</p>

<h3>Order Tracking</h3>
<p>Once your order is shipped, you will receive tracking details by SMS or email. You can also track it from the My Orders section of your account.</p>

<h3>Incorrect Address or Failed Delivery</h3>
<p>Please make sure your address and mobile number are correct. We are not responsible for delays or non-delivery caused by incorrect details.</p>

<h3>Contact Us</h3>
<p>Email: [[email]]<br>Phone: [[phone]]</p>
HTML,
            ],

            [
                'slug' => 'returns-exchange',
                'heading' => 'Returns & Exchange',
                'short_description' => 'How to return or exchange a product bought from [[site_name]].',
                'meta_title' => 'Returns & Exchange | [[site_name]]',
                'meta_description' => 'Our return and exchange policy, eligibility and process.',
                'content' => <<<'HTML'
<p>We want you to love what you ordered from <strong>[[site_name]]</strong>. If something is not right, you can request a return or exchange as described below.</p>

<h3>Eligibility</h3>
<ul>
  <li>Request within 7 days of delivery.</li>
  <li>The product must be unused, unwashed and in its original packaging with all tags intact.</li>
  <li>Products received damaged, defective or incorrect are eligible for replacement or refund.</li>
</ul>

<h3>Non-Returnable Items</h3>
<ul>
  <li>Customised or made-to-measure products.</li>
  <li>Items bought during clearance sales marked as final sale.</li>
  <li>Products damaged due to misuse or improper care.</li>
</ul>

<h3>How to Request</h3>
<ol>
  <li>Email us at [[email]] or call [[phone]] with your order number.</li>
  <li>Share clear photos or an unboxing video if the item is damaged or incorrect.</li>
  <li>Once approved, we will arrange pickup or share return instructions.</li>
</ol>

<h3>Exchange</h3>
<p>Exchanges are subject to stock availability. If the requested item is unavailable, we will issue a refund.</p>
HTML,
            ],

            [
                'slug' => 'refund-cancellation-policy',
                'heading' => 'Refund & Cancellation Policy',
                'short_description' => 'Order cancellation rules and refund timelines at [[site_name]].',
                'meta_title' => 'Refund & Cancellation Policy | [[site_name]]',
                'meta_description' => 'Understand how order cancellation and refunds work.',
                'content' => <<<'HTML'
<h3>Cancellation</h3>
<ul>
  <li>You can cancel an order before it is shipped by contacting us at [[email]] or [[phone]].</li>
  <li>Once an order is shipped, it cannot be cancelled, but you may use our return process if eligible.</li>
  <li>Customised orders cannot be cancelled once production has started.</li>
</ul>

<h3>Refunds</h3>
<ul>
  <li>Approved refunds are credited to the original payment method within 7–10 business days after we receive and inspect the returned product.</li>
  <li>For Cash on Delivery orders, the refund is made by bank transfer to the account details you provide.</li>
  <li>Shipping charges, if any, are non-refundable unless the return is due to our error.</li>
</ul>

<h3>Failed or Double Payments</h3>
<p>If money was deducted but the order was not confirmed, the amount is automatically refunded by the payment gateway within 5–7 business days. If it does not arrive, please contact us with your transaction details.</p>

<h3>Contact Us</h3>
<p>Email: [[email]]<br>Phone: [[phone]]<br>Address: [[address]]</p>
HTML,
            ],

        ];

        foreach ($pages as $p) {
            DynamicPage::firstOrCreate(
                ['slug' => $p['slug']],
                $p + ['status' => true]
            );
        }
    }
}