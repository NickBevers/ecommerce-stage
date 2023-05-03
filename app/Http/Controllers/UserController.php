<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
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

    public function update(Request $request, User $user)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('profile.userEdit');
    }

    public function updateBankAccount(Request $request)
    {
        $request->validate([
            'bank_account' => 'required',
            'password_confirm' => 'required',
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        $hashedPassword = User::where('id', $user->id)->first()->password;
        if (!password_verify($request->password_confirm, $hashedPassword)) {
            return redirect()->back()->with('error', 'Password is incorrect');
        }

        $user->bank_account = $request->bank_account;
        $user->save();

        return redirect()->route('profile.edit');
    }

    public function validatePassword(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $hashedPassword = User::where('id', $user->id)->first()->password;

        if (!password_verify($request->password, $hashedPassword)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password is incorrect'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Password is correct'
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('login');
    }
}