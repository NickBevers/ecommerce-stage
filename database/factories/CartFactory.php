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
            'attributes' => [
                AttributeValue::where('attribute_type_id', 1)->get()->random()->id,
                AttributeValue::where('attribute_type_id', 2)->get()->random()->id,
                AttributeValue::where('attribute_type_id', 3)->get()->random()->id
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
