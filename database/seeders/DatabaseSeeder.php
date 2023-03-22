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
            UserSeeder::class,
            AttributeTypeSeeder::class,
            AttributeValueSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            SkuSeeder::class,
        ]);

        Sku::all()->each(function (Sku $sku) {
            for ($i = 0; $i < 3; $i++) {
                $sku->attributeValues()->attach(
                    AttributeValue::where('attribute_type_id', $i+1)->inRandomOrder()->first(),
                );
            }
        });
    }
}
