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
        // First, get all the SKUs
        $skus = Sku::all();
        $colorSizes = ColorSize::all();
//        ray($colorSizes[0]);
//        ray($colorSizes[0]->color()->first());
//        ray($colorSizes[0]->size()->first());

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
//
//            ray($variation);
//            ray($variation->id);
//            ray(get_class($variation));

            // Create the variation record
            $sku->variations()->create([
                'variation_id' => $variation->id,
                'variation_type' => get_class($variation),
            ]);
        }
    }
}
