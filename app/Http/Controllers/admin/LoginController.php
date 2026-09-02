<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'referral_code';

        if (Auth::attempt([$fieldType => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::user();

            if (! $user->isAdmin()) {
                Auth::logout();

                return back()->withErrors(['email' => 'Access denied. Administrator privileges required.']);
            }

            if ($user->status !== 'active') {
                Auth::logout();

                return back()->withErrors(['email' => 'Your admin account is currently inactive.']);
            }

            $request->session()->regenerate();
            session(['admin_user_id' => $user->id]);

            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, '.$user->name);
        }

        return back()->withErrors(['email' => 'Invalid admin credentials provided.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->forget(['admin_user_id', 'impersonated_user_id']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('info', 'Logged out successfully.');
    }
}
