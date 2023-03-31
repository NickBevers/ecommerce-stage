<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class UserController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request)
    {
        // TODO: validate the request and put it in a request class
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
        return User::findOrFail($user->id);
    }

    public function update(Request $request, User $user)
    {
        // TODO: validate the request and put it in a request class
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $hashedPassword = User::where('id', $user->id)->first()->password;

        if (!password_verify($request->password, $hashedPassword)) {
            return redirect()->back()->with('error', 'Password is incorrect');
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return redirect()->route('users.index');
    }

    public function updateBankAccount(Request $request, User $user)
    {
        $request->validate([
            'bank_account' => 'required',
        ]);

        $user->bank_account = $request->bank_account;
        $user->save();

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('login');
    }
}