<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $subCategories = [
            [
                "T-shirts",
                "Sweaters",
                "Jackets",
                "Shirts",
                "Suits",
                "Sportswear",
                "Dresses",
                "Pyjamas",
                "Pants",
                "Shorts",
                "Underwear",
                "Skirts",
                "Swimwear",
            ],

            [
                "Boots",
                "Sneakers",
                "Sandals",
                "Heels",
                "Sports shoes",
                "Slippers",
                "Outdoor shoes",
                "Dress shoes",
            ],

            [
                "Watches",
                "Bags",
                "Scarves",
                "Belts",
                "Caps & Hats",
                "Jewelry",
                "Socks",
                "Sunglasses",
            ]
        ];

        $icons = [
            '/shirt.svg',
            '/pants.svg',
        ];

        foreach ($subCategories as $array){
            foreach ($array as $subCategory) {
                SubCategory::create([
                    'category_id' => 1,
                    'name' => $subCategory,
                    'icon' => $icons[array_rand($icons)],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
