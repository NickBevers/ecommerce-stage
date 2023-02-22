<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Cart::factory()->count(10)->create();
    }
}
