<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\ColorSize;
use App\Models\Sku;
use Illuminate\Database\Seeder;

class SkuSeeder extends Seeder
{
    public function run(): void
    {
        Sku::factory()->count(100)->create();
    }
}
