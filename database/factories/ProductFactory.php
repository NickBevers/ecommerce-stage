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

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'audience' => $this->faker->randomElement(['Man', 'Women', 'Kids', 'Unisex']),
            'sub_category_id' => SubCategory::all()->random()->id,
            'extra_info' => $this->faker->word(),
            'is_active' => $this->faker->boolean(),
            'user_id' => 1,
            'brand_id' => Brand::all()->random()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
