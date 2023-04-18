<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
//        seed 2 reviews for each sku
        $skus = \App\Models\Sku::all();
        foreach ($skus as $sku) {
            Review::factory()->count(2)->create([
                'sku_id' => $sku->id,
            ]);
        }
    }
}
