<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Upvote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    private Int $user_id = 3;
    public function store(Request $request)
    {
        $request->validate([
            'sku_id' => 'required',
            'title' => 'required',
            'body' => 'required',
            'score' => 'required',
        ]);

        $request->merge(['user_id' => Auth::user()->id]);

        $review = Review::create($request->all());
        return response()->json([
            'review' => $review,
        ]);
    }

    public function markAsUseful(Review $review)
    {
        $upvote = $review->upvotes->where('user_id', Auth::user()->id)->first();
        if ($upvote) {
            return response()->json([
                'upvotes' => count($review->upvotes),
            ]);
        }

        Upvote::create([
            'user_id' => Auth::user()->id,
            'review_id' => $review->id,
        ]);

        // return count($review->upvotes);

        return response()->json([
            'upvotes' => count($review->upvotes),
        ]);
    }

    public function markAsNotUseful(Review $review)
    {
        $upvote = $review->upvotes->where('user_id', Auth::user()->id)->first();
        if (!$upvote) {
            return response()->json([
                  'upvotes' => count($review->upvotes),
            ]);
        }

        $upvote = $review->upvotes->where('user_id', Auth::user()->id)->first();
        $upvote?->delete();

        return count($review->upvotes);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('products.index')->with('success', 'Review deleted successfully');
    }
}