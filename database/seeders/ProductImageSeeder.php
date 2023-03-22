<?php

namespace Database\Seeders;

use App\Models\Sku;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            "https://files.nickbevers.be/brownVest.jpg",
            "https://files.nickbevers.be/leaveTheRoadShirt.jpg",
            "https://files.nickbevers.be/pinkPants.jpg",
            "https://files.nickbevers.be/scarf.jpg",
            "https://files.nickbevers.be/whiteShirt.jpg",
        ];

        $alt = [
            "Brown vest",
            "Leave the road shirt",
            "Pink pants",
            "Scarf",
            "White shirt",
        ];

        Sku::all()->each(function (Sku $sku) use ($images, $alt) {
            for ($i = 0; $i < 3; $i++) {
                $sku->productImages()->create([
                    'image_type' => $i === 0 ? 'thumbnail' : 'image',
                    'image_link' => $images[array_rand($images)],
                    'image_public_id' => 'public_id',
                    'alt' => $alt[array_rand($alt)],
                ]);
            }
        });
    }
}
