<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Sku;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
//        use the sku_id and user_id from the ReviewSeeder
        return [
            'title' => $this->faker->word(),
            'body' => $this->faker->word(),
            'score' => $this->faker->numberBetween(1, 5),
            'approved' => $this->faker->boolean(),
            'useful_count' => $this->faker->numberBetween(0, 100),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => User::all()->random()->id,
        ];
    }
}
