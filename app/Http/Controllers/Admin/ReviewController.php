<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Sku;

class ReviewController extends Controller
{
    public function getAllReviews(Sku $sku)
    {
        return [
            "reviews" => Review::where('sku_id', $sku->id)->get(),
            "averageScore" => Review::where('sku_id', $sku->id)->avg('score'),
        ];
    }

    public function toggleInactive(Sku $sku)
    {
        $review = Review::find($sku->id);
        $review->approved = !$review->approved;
        $review->save();
        return redirect()->route('products.index');
    }
}