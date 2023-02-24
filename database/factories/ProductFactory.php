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
            'price' => $this->faker->NumberBetween(10, 200),
            'stock' => $this->faker->NumberBetween(10, 50),
            'category_id' => $this->faker->NumberBetween(1, 10),
            'promos' => $this->faker->words(),
            'extra_info' => $this->faker->word(),
            'images' => 'https://picsum.photos/200/300',
            'sku' => $this->faker->word(),
            'product_number' => $this->faker->randomNumber(),
            'is_promotion' => $this->faker->boolean(),
            'is_active' => $this->faker->boolean(),
            'seller_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
