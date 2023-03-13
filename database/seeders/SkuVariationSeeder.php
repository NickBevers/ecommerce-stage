<?php

namespace Database\Seeders;

use App\Models\AttributeType;
use App\Models\AttributeValue;
use App\Models\ColorSize;
use App\Models\Sku;
use Illuminate\Database\Seeder;

class SkuVariationSeeder extends Seeder
{
    public function run(): void
    {
        $skus = Sku::all();
        $colorSizes = ColorSize::all();
        $attributeValues = AttributeValue::where('attribute_type_id', 3)->get();


        foreach ($skus as $sku) {
            $variation = null;
            $rand = rand(0, 1);

            if ($rand === 0) {
                $variation = $colorSizes->random(1)->first();
            }
            if ($rand === 1){
                $variation = $attributeValues->random(1)->first();
            }


            $sku->variations()->create([
                'variation_id' => $variation->id,
                'variation_type' => get_class($variation),
            ]);
        }
    }
}
