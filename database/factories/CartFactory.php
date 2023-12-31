<?php

namespace Database\Factories;

use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Sku;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'sku_id' => Sku::all()->random()->id,
            'amount' => $this->faker->numberBetween(1, 8),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
