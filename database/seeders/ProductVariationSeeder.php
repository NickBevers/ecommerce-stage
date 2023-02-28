<?php

namespace Database\Seeders;

use App\Models\ProductVariation;
use Illuminate\Database\Seeder;

class ProductVariationSeeder extends Seeder
{
    public function run(): void
    {
        ProductVariation::factory()
            ->count(100)
            ->create();
    }
}
