<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(Request $request): View
    {
        $sponsor = $request->query('sponsor', 'NGF-0000001');

        return view('user.auth.register', compact('sponsor'));
    }

    public function register(Request $request): View
    {
        $request->validate([
            'sponsor_id' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required',
            'position' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $referralCode = User::generateReferralCode();
        $txPin = (string) rand(100000, 999999);

        // New member account created as inactive by default until package investment
        $user = User::create([
            'role_id' => 2,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'referral_code' => $referralCode,
            'sponsor_code' => $request->sponsor_id,
            'position' => strtolower($request->position),
            'status' => 'inactive',
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $registeredUser = [
            'user_id' => $user->referral_code,
            'sponsor_id' => $user->sponsor_code,
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'position' => strtoupper($user->position),
            'tx_pin' => $txPin,
        ];

        return view('user.auth.register', [
            'sponsor' => $user->sponsor_code,
            'registeredUser' => $registeredUser,
            'showModal' => true,
        ]);
    }
}
