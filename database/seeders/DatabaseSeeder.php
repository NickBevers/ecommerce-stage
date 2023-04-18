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
            VatSeeder::class,
            BrandSeeder::class,
            PaymentTypeSeeder::class,
            ProductSeeder::class,
            SkuSeeder::class,
            ProductImageSeeder::class,
            PromoSeeder::class,
            ReviewSeeder::class,
            CartSeeder::class,
            WishlistSeeder::class,
        ]);

        Sku::inRandomOrder()->limit(500)->get()->each(function (Sku $sku) {
            for ($i = 0; $i < 3; $i++) {
                $sku->attributeValues()->attach(
                    AttributeValue::where('attribute_type_id', $i+1)->inRandomOrder()->first(),
                );
            }
        });
    }
}
