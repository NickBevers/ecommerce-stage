<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index()
    {
    }

    public function getSubCategoriesById($id)
    {
        return SubCategory::all()->where('category_id', '=', $id)->map(function ($subCategory) {
            return [
                'id' => $subCategory->id,
                'name' => $subCategory->name,
                'category_id' => $subCategory->category_id,
            ];
        });
    }

    public function getAllSubCategories()
    {
        return SubCategory::all()->map(function ($subCategory) {
            return [
                'id' => $subCategory->id,
                'name' => $subCategory->name,
            ];
        });
    }
}