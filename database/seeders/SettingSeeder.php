<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Site me ek hi settings row hoti hai (Setting::first()), isliye id = 1 par updateOrCreate
        Setting::updateOrCreate(
            ['id' => 1],
            [
                // Branding
                'site_name'            => 'Archana Saree Emporium',
                'tagline'              => 'Premium Sarees · Designer Lehengas · Bridal Wear',
                'header_logo'          => null,
                'footer_logo'          => null,
                'favicon'              => null,
                'admin_login_logo'     => null,
                'admin_dashboard_logo' => null,

                // Contact (placeholder: apni real details daalo)
                'admin_email'          => 'admin@example.com',
                'support_email'        => 'support@example.com',
                'phone'                => '+91 98765 43210',
                'whatsapp'             => '9876543210',
                'business_address'     => "Chandni Chowk\nDelhi - 110006, India",
                'google_map_url'       => null,

                // Footer
                'footer_description'   => 'Timeless Indian elegance, thoughtfully curated for every celebration.',
                'footer_copyright'     => '© ' . date('Y') . ' Archana Saree Emporium. All Rights Reserved.',

                // Social (khali = layout me hide ho jayega)
                'facebook'             => null,
                'instagram'            => null,
                'twitter'              => null,
                'linkedin'             => null,
                'youtube'              => null,
                'pinterest'            => null,

                // Store
                'currency'             => 'INR',
                'currency_symbol'      => '₹',
                'timezone'             => 'Asia/Kolkata',

                // System
                'maintenance_mode'      => false,
                'admin_session_timeout' => 30,

                // Features
                'product_reviews'      => true,
                'wishlist'             => true,
                'stock_alerts'         => true,
                'cod_enabled'          => true,
            ]
        );
    }
}