<?php

namespace Database\Factories;

use App\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkuFactory extends Factory
{
    protected $model = Sku::class;

    public function definition(): array
    {
        return [
            'sku' => $this->faker->unique()->randomNumber(8),
            'product_id' => $this->faker->numberBetween(1, 100),
            'amount' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 1, 100)
        ];
    }
}
