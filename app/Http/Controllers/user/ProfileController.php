<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display member profile & security settings page.
     */
    public function index(): View
    {
        $user = Auth::user();
        $user->load('sponsor');

        return view('user.profile', compact('user'));
    }

    /**
     * Update member personal information.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
        ]);

        return redirect()->back()->with('success', 'Profile details updated successfully!');
    }

    /**
     * Change member account password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Your current password does not match our records.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Account password changed successfully!');
    }
}
