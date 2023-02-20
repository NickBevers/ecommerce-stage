<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class UsersController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|unique:App\Models\User,email',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', // at least 1 lowercase, 1 uppercase, 1 number
        ]);

        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->created_at = now();
        $user->save();
    }

    public function show(User $user)
    {
        User::find($user->id);
    }

    public function edit(User $user)
    {
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:App\Models\User,email',
            'password' => 'required',
        ]);

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return redirect()->route('users.index');
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user->password = $request->password;
        $user->save();

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
    }
}