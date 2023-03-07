<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = file(public_path('zalando-brands.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($brands as $brand) {
            Brand::create([
                'name' => trim($brand),
                'slug' => preg_replace("/[^a-zA-Z0-9]+/", "", strtolower(trim($brand))),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
