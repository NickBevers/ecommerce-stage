<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAllCategories()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'subcategories' => 'required',
        ]);

        $category = Category::create($request->all());

        $subcategories = $request->subcategories;
        foreach ($subcategories as $subcategory) {
            $category->subcategories()->create($subcategory);
        }

        return $category;
    }
}