<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    public function updateUserLevel(Request $request)
    {
        // update the user's user_type depending on the value of the select
        $user = User::where('id', $request->user_id)->first();
        $user->user_type = $request->user_type;
        $user->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function orders(Request $request): Response
    {
        $orders = Order::orderBy('created_at', 'desc')->get();

        $ordersWithAddresses = [];

        foreach ($orders as $order) {
            $ordersWithAddresses[] = [
                'order' => $order->withRelations()->get()->first(),
                'shipping_address' => Address::where('id', $order->shipping_address_id)->first(),
                'billing_address' => Address::where('id', $order->billing_address_id)->first(),
            ];
        }

        return Inertia::render('Customer/Profile/Details/Orders', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'orders' => $ordersWithAddresses,
        ]);
    }

    /**
     * Edit user 
     */

     public function userEdit(Request $request): Response
    {
        return Inertia::render('Customer/Profile/Index', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function editPassword(Request $request): Response
    {
        return Inertia::render('Customer/Profile/Details/Password', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function editAdvanced(Request $request): Response
    {
        return Inertia::render('Customer/Profile/Details/Advanced', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }
}
