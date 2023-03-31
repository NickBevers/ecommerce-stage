<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Upvote;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    private Int $user_id = 3;
    public function store(Request $request)
    {
        $review = Review::create($request->all());
        return redirect()->route('products.index')->with('success', 'Review created successfully');
    }

    public function markAsUseful(Review $review)
    {
        Upvote::create([
            'user_id' => $this->user_id,
            'review_id' => $review->id,
        ]);

        return count($review->upvotes);
    }

    public function markAsNotUseful(Review $review)
    {
        $upvote = $review->upvotes->where('user_id', $this->user_id)->first();
        if ($upvote) {
            $upvote->delete();
        }

        return count($review->upvotes);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('products.index')->with('success', 'Review deleted successfully');
    }
}