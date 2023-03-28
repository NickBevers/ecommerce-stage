<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function getAllReviews($skuId)
    {
        return [
            "reviews" => Review::where('sku_id', $skuId)->get(),
            "averageScore" => Review::where('sku_id', $skuId)->avg('score'),
        ];
    }

    public function toggleInactive($id)
    {
        $review = Review::find($id);
        $review->approved = !$review->approved;
        $review->save();
        return redirect()->route('products.index');
    }
}