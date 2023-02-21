<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingAddress;

class ShippingAddressSeeder extends Seeder
{
    public function run(): void
    {
        ShippingAddress::factory()->count(10)->create();
    }
}
