<?php

namespace Database\Factories;

use App\Models\Product;
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
            'audience' => $this->faker->word(),
            'category_id' => $this->faker->NumberBetween(1, 10),
            'promos' => $this->faker->words(),
            'extra_info' => $this->faker->word(),
            'is_promotion' => $this->faker->boolean(),
            'is_active' => $this->faker->boolean(),
            'sku' => $this->faker->numerify('####-####-####'),
            'seller_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
