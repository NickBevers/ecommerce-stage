<?php

namespace Database\Factories;

use App\Models\ColorVariation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ColorVariationFactory extends Factory
{
    protected $model = ColorVariation::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->unique()->safeColorName(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
