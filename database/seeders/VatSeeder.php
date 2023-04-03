<?php

namespace Database\Seeders;

use App\Models\Vat;
use Illuminate\Database\Seeder;

class VatSeeder extends Seeder
{
    public function run(): void
    {
        // insert 1 record in the database table
        Vat::create([
            'vat' => '21',
            'vat_percentage' => '21',
            'country_code' => 'BE',
        ]);
    }
}