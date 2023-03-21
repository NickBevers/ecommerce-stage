<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        Review::create($request->all());
        return redirect()->route('products.index');
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

    public function destroy($id)
    {
        Review::destroy($id);
        return redirect()->route('products.index');
    }
}