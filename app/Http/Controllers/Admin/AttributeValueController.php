<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;

class AttributeValueController extends Controller
{
    public function getValuesByType(String $name)
    {
        return AttributeValue::whereHas('attributeType', function ($query) use ($name) {
            $query->where('name', $name);
        })->get('name');
    }
}