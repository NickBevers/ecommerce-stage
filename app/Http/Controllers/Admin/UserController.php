<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $customers = User::all('id', 'firstname', 'lastname', 'email', 'user_type')->whereNotIn('id', Auth::user()->id)->toArray();

        return Inertia::render('Admin/Customers/Index', [
            'customers' => $customers,
        ]);
    }
}
