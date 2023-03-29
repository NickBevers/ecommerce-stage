<?php

namespace App\Services;

use App\Models\Brand;

class GetBrandsService
{
    public function getBrands()
    {
        return Brand::all()->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'slug' => $brand->slug,
            ];
        });
    }
}