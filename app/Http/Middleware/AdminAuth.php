<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If an admin user ID exists in session, ensure Auth::user() evaluates as Admin for admin routes
        if (session()->has('admin_user_id')) {
            $admin = User::find(session('admin_user_id'));
            if ($admin && $admin->isAdmin()) {
                Auth::setUser($admin);

                return $next($request);
            }
        }

        if (! Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please log in to access the Admin Panel.');
        }

        if (! Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access. Administrator privileges required.');
        }

        return $next($request);
    }
}
