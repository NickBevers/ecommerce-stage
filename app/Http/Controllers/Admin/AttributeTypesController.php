<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeType;
use Illuminate\Http\Request;

class AttributeTypesController extends Controller
{
    public function index()
    {

    }

    public function getAllTypes()
    {
        return AttributeType::all();
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(AttributeType $attributeType)
    {
    }

    public function edit(AttributeType $attributeType)
    {
    }

    public function update(Request $request, AttributeType $attributeType)
    {
    }

    public function destroy(AttributeType $attributeType)
    {
    }
}