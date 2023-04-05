<?php

namespace App\Services;

use App\Models\Vat;

class VatService
{
    public function getCountries(): array
    {
        return Vat::select('country')->distinct()->get()->pluck('country')->toArray();
    }

    public function getVatsByCountryCode(string $code): array
    {
        return Vat::where('country_code', strtoupper($code))->get()->unique('vat_rate')->sortBy('vat_rate')->toArray();
    }
}