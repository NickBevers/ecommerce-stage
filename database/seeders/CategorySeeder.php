<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Clothing',
            'Shoes',
            'Accessories',
            'Brands',
            'Promo',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
