<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Upvote;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class ReviewController extends Controller
{
    private Int $user_id = 3;
    public function store(Request $request)
    {
        $review = Review::create($request->all());
        return redirect()->route('products.index');
//        return $review;
    }

    public function markAsUseful($id)
    {
        $review = Review::find($id);
        Upvote::create([
            'user_id' => $this->user_id,
            'review_id' => $id,
        ]);
//        return redirect()->route('products.index');

        return count($review->upvotes);
    }

    public function markAsNotUseful($id)
    {
        $review = Review::find($id);
        $upvote = $review->upvotes->where('user_id', $this->user_id)->first();
        if ($upvote) {
            $upvote->delete();
        }

        return count($review->upvotes);
    }

    public function destroy($id)
    {
        Review::destroy($id);
        return redirect()->route('products.index');
    }
}