<?php

namespace Database\Factories;

use App\Models\ColorVariation;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductVariationFactory extends Factory
{
    protected $model = ProductVariation::class;

    public function definition(): array
    {
        return [
            'color_variation_id' => $this->faker->randomElement(ColorVariation::all()->pluck('id')->toArray()),
            'price' => $this->faker->randomNumber(),
            'amount' => $this->faker->randomNumber(),
            'variation_number' => $this->faker->numerify('####-####-####') . '-' . $this->faker->safeColorName(),
            'sizes' => [
                'S',
                'M',
                'L',
                'XL',
                'XXL',
            ],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'product_id' => Product::factory()->create()->id,
            'in_stock' => '1',
            'images' => [ 1 ],
        ];
    }
}
