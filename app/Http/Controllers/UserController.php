<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidationRequest;
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

    public function store(UserValidationRequest $request)
    {
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

    public function update(UserValidationRequest $request, User $user)
    {
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

    public function updateBankAccount(Request $request)
    {
        $request->validate([
            'bank_account' => 'required',
        ]);

        $user = User::where('id', Auth::user()->id)->first();

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