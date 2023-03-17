<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index()
    {
    }

    public function getAll()
    {
        return Category::all()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'subCategories' => array_values($this->getSubCategoriesById($category->id)->toArray()),
            ];
        });
    }

    public function getSubCategoriesById($id)
    {
        return SubCategory::all()->where('category_id', '=', $id)->map(function ($subCategory) {
            return [
                'id' => $subCategory->id,
                'name' => $subCategory->name,
                'slug' => $subCategory->slug,
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