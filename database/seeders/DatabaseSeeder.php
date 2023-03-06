<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Sku;
use App\Models\AttributeType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AttributeTypeSeeder::class,
            AttributeValueSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            ProductSeeder::class,
            SkuSeeder::class,
        ]);


        Sku::all()->each(function (Sku $sku) {
            $sku->attributeValues()->attach(
                AttributeValue::all()->random(3)
            );
        });
    }
}
