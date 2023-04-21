<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $customers = User::all('id', 'firstname', 'lastname', 'email', 'user_type')->toArray();

        return Inertia::render('Admin/Customers/Index', [
            'customers' => $customers,
        ]);
    }
}
