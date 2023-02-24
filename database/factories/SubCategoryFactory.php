<?php

namespace Database\Factories;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SubCategoryFactory extends Factory
{
    protected $model = SubCategory::class;

    public function definition(): array
    {
        return [
            'category_id' => $this->faker->NumberBetween(1, 10),
            'label' => $this->faker->word(),
            'value' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
