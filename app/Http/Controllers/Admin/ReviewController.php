<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
    }

    public function getAllReviews($skuId)
    {
        return [
            "reviews" => Review::where('sku_id', $skuId)->get(),
            "averageScore" => Review::where('sku_id', $skuId)->avg('score'),
        ];
    }

    public function store(Request $request)
    {
        Review::create($request->all());
        return redirect()->route('products.index');
    }
    public function show(Review $review)
    {
    }

    public function markAsUseful($id)
    {
        $review = Review::find($id);
        $review->useful_count++;
        $review->save();
        return redirect()->route('products.index');
    }

    public function markAsNotUseful($id)
    {
        $review = Review::find($id);
        $review->useful_count--;
        $review->save();
        return redirect()->route('products.index');
    }

    public function toggleInactive($id)
    {
        $review = Review::find($id);
        $review->approved = !$review->approved;
        $review->save();
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        Review::destroy($id);
        return redirect()->route('products.index');
    }
}