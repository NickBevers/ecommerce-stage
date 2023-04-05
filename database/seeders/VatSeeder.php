<?php

namespace Database\Seeders;

use App\Models\Vat;
use Illuminate\Database\Seeder;

class VatSeeder extends Seeder
{
    public function run(): void
    {
        // read the json file and loop through it to create the vats
        $json = file_get_contents(public_path('vat_rates.json'));
        $vats = json_decode($json, true);
        foreach ($vats as $vat) {
            Vat::create([
                'country' => $vat['country'],
                'country_code' => $vat['country_code'],
                'vat_type' => $vat['vat_type'],
                'vat_rate' => $vat['percentage'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}