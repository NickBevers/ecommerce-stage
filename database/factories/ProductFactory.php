<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    private function slugify($string): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }

    public function definition(): array
    {
        return [
            'title' => $title = $this->faker->unique()->words(2, true),
            'slug' => $this->slugify($title),
            'description' => "This is a product description where we provide the information required for the customer to make a decision on whether to purchase the product or not. A customer can decide to purchase the product based on the information provided in this description.",
            'audience' => $this->faker->randomElement(['Men', 'Women', 'Kids', 'Unisex']),
            'sub_category_id' => SubCategory::all()->random()->id,
            'product_type' => $this->faker->randomElement(['simple', 'variable']),
            'extra_info' => $this->faker->word(),
            'user_id' => 1,
            'brand_id' => Brand::all()->random()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
