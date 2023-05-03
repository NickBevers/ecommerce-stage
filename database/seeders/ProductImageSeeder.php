<?php

namespace Database\Seeders;

use App\Models\Sku;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    private function generateRandomString($length = 16) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function run(): void
    {
        $images = [
            "https://files.nickbevers.be/brownVest.webp",
            "https://files.nickbevers.be/leaveTheRoadShirt.webp",
            "https://files.nickbevers.be/pinkPants.webp",
            "https://files.nickbevers.be/scarf.webp",
            "https://files.nickbevers.be/whiteShirt.webp",
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
                    'image_type' => $i === 0 ? 'thumbnails' : 'product',
                    'image_link' => $images[array_rand($images)],
                    'image_public_id' => $this->generateRandomString(),
                    'alt' => $alt[array_rand($alt)],
                ]);
            }
        });
    }
}
