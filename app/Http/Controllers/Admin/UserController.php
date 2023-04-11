<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get('id', 'firstname', 'lastname', 'email', 'created_at', 'updated_at')->toArray();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }
}
