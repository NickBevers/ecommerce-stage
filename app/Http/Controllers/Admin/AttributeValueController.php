<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;

class AttributeValueController extends Controller
{
    public function index()
    {
    }

    public function getSizes()
    {
        return AttributeValue::all()->where('attribute_type_id', '=', 1)->map(function ($size) {
            return $size->name;
        });
    }

    public function getColors()
    {
        return AttributeValue::all()->where('attribute_type_id', '=', 2)->map(function ($color) {
            return $color->name;
        });
    }

    public function getMaterials()
    {
        return AttributeValue::all()->where('attribute_type_id', '=', 3)->map(function ($material) {
            return $material->name;
        });
    }
}