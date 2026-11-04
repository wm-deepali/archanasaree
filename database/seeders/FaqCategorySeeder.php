<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\FaqCategory;

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

        foreach ($cats as $i => [$name, $icon]) {
            FaqCategory::updateOrCreate(
                ['name' => $name],
                ['icon' => $icon, 'sort_order' => $i + 1, 'status' => 1]
            );
        }
    }

}