<?php

namespace Database\Seeders;

use App\Models\ColorVariation;
use Illuminate\Database\Seeder;

class ColorVariationSeeder extends Seeder
{
    public function run(): void
    {
        ColorVariation::factory()->count(10)->create();
    }
}
