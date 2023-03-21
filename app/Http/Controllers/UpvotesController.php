<?php

namespace App\Http\Controllers;

use App\Models\Upvote;
use Illuminate\Http\Request;

class UpvotesController extends Controller
{
    public function store(Request $request)
    {
        Upvote::create($request->all());
    }

    public function destroy(Upvote $upvote)
    {
        Upvote::destroy($upvote->id);
    }
}