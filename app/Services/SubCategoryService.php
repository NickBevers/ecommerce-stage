<?php

namespace App\Services;

use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryService
{
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
        return SubCategory::all()->where('category_id', $id)->map(function ($subCategory) {
            return [
                'id' => $subCategory->id,
                'name' => $subCategory->name,
                'slug' => $subCategory->slug,
                'category_id' => $subCategory->category_id,
            ];
        });
    }

    public function getSubCategoryBySlug($name)
    {
        return SubCategory::where('slug', $name)->get('name')->first();
    }
}