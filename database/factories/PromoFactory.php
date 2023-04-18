<?php

namespace Database\Factories;

use App\Models\Promo;
use App\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PromoFactory extends Factory
{
    protected $model = Promo::class;

    public function definition(): array
    {
        return [
            'sku_id' => Sku::all()->random()->id,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(random_int(1, 30)),
            'extra_info' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'new_price_excl_vat' => random_int(1, 100),
            'new_price_incl_vat' => random_int(1, 100),
        ];
    }
}
