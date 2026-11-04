<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Seeder;

class FaqCategorySeeder extends Seeder
{
    public function run(): void
    {
        $cats = [
            ['Shopping & Collections', 'fa-solid fa-bag-shopping'],
            ['Product & Size', 'fa-solid fa-ruler-combined'],
            ['Orders & Payments', 'fa-solid fa-credit-card'],
            ['Shipping & Delivery', 'fa-solid fa-truck-fast'],
            ['Returns & Exchanges', 'fa-solid fa-rotate-left'],
            ['Store & Support', 'fa-solid fa-store'],
        ];

        $categoryIds = [];

        foreach ($cats as $i => [$name, $icon]) {
            $category = FaqCategory::updateOrCreate(
                ['name' => $name],
                ['icon' => $icon, 'sort_order' => $i + 1, 'status' => 1]
            );

            $categoryIds[$name] = $category->id;
        }

        $faqs = [

            'Shopping & Collections' => [
                [
                    'What collections can I shop at Archana Saree Emporium?',
                    'Explore our curated collection of premium sarees, designer lehengas, bridal wear and occasion-ready styles. Our collections are designed for weddings, festive celebrations, parties and special moments.',
                ],
                [
                    'How do I choose the right saree for an occasion?',
                    'Consider the occasion, fabric, colour, embroidery and overall styling you prefer. For weddings and festive celebrations, silk, Banarasi and richly detailed sarees are popular choices, while lighter fabrics and elegant drapes work beautifully for parties and intimate occasions.',
                ],
                [
                    'Do you offer bridal sarees and wedding wear?',
                    'Yes. Our bridal and wedding collections feature statement sarees and traditional occasion wear designed for memorable celebrations. Explore the bridal collection or contact our team for assistance in finding the right style.',
                ],
                [
                    'Do you have sarees for parties and festive occasions?',
                    'Yes. Our collection includes elegant sarees suited for festive gatherings, parties, receptions and special occasions, with a variety of fabrics, colours and embellishment styles.',
                ],
                [
                    'Do you also offer designer lehengas?',
                    'Yes. We offer designer lehengas and statement occasion wear suitable for weddings, receptions, engagements, festive celebrations and other special occasions.',
                ],
            ],

            'Product & Size' => [
                [
                    'How can I check the details of a saree or lehenga before ordering?',
                    'Open the product page to view the available images, fabric or material details, colour information, product description, pricing, offers and other available specifications before placing your order.',
                ],
                [
                    'How do I choose the right size for a lehenga or other fitted outfit?',
                    'Check the size information provided on the product page before ordering. If you need help understanding measurements or choosing between sizes, contact our team before placing your order.',
                ],
                [
                    'Will the colour of the product look exactly the same as shown online?',
                    'We make every effort to display product colours as accurately as possible. However, slight variations may occur due to photography, lighting and individual screen settings.',
                ],
                [
                    'Can I ask about product availability before ordering?',
                    'Yes. If you want to confirm availability, colour options or product details before purchasing, contact our team through the available call or WhatsApp options.',
                ],
            ],

            'Orders & Payments' => [
                [
                    'How can I place an order?',
                    'Select the product you want, choose the available options where applicable, add it to your bag and proceed through checkout to complete your purchase.',
                ],
                [
                    'What payment methods are available?',
                    'Available payment methods will be displayed during checkout. Please review the payment options shown for your order before completing the purchase.',
                ],
                [
                    'Can I cancel my order after placing it?',
                    'Order cancellation depends on the order status and applicable store policy. If you need to cancel an order, contact our customer support team as soon as possible with your order details.',
                ],
                [
                    'How can I get help with my order?',
                    'Contact our team with your order number and the details of your query. We can assist with order-related questions, product information and available delivery or support updates.',
                ],
            ],

            'Shipping & Delivery' => [
                [
                    'How long will my order take to arrive?',
                    'Delivery time can vary depending on your location, product availability and the shipping method used. The applicable delivery information will be provided during the ordering process.',
                ],
                [
                    'Can I track my order?',
                    'If tracking is available for your shipment, tracking details will be shared once your order has been dispatched. Use the provided tracking information to follow your shipment.',
                ],
                [
                    'Do you deliver across India?',
                    'Delivery availability depends on the serviceable location and the shipping options available at checkout. Enter your delivery details during checkout to confirm availability.',
                ],
                [
                    'What should I do if my order is delayed?',
                    'If your order has not arrived within the expected delivery period, contact our support team with your order number so we can help check the latest available shipment information.',
                ],
            ],

            'Returns & Exchanges' => [
                [
                    'Can I return or exchange a product?',
                    'Returns and exchanges are subject to the applicable product and store policy. Please review the Returns & Exchanges policy for eligibility, timelines, product conditions and exclusions before raising a request.',
                ],
                [
                    'What should I do if I receive a damaged or incorrect product?',
                    'Contact our support team as soon as possible after receiving the order and provide your order details along with the required product photographs or information. Our team will guide you through the next steps according to the applicable policy.',
                ],
            ],

            'Store & Support' => [
                [
                    'Can I visit Archana Saree Emporium in person?',
                    'Yes. If you prefer to explore the collection in person, you can visit our store during business hours. Please use the Contact page for the latest store address, opening hours and directions.',
                ],
                [
                    'Can I contact you on WhatsApp before buying?',
                    'Yes. WhatsApp is a convenient way to ask about product availability, colours, sizes, styling options and general shopping queries before placing your order.',
                ],
                [
                    'How can I contact Archana Saree Emporium?',
                    'You can contact our team through phone, WhatsApp, email or by visiting the store. Please visit the Contact page for the available contact details and store information.',
                ],
            ],
        ];

        foreach ($faqs as $categoryName => $items) {
            foreach ($items as $i => [$question, $answer]) {
                Faq::updateOrCreate(
                    ['question' => $question],
                    [
                        'faq_category_id' => $categoryIds[$categoryName],
                        'answer'          => $answer,
                        'sort_order'      => $i + 1,
                        'show_home'       => false,
                        'status'          => true,
                    ]
                );
            }
        }
    }
}