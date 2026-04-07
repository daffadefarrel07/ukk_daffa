<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Allow if user has is_admin flag
        if ($user && ! empty($user->is_admin)) {
            return $next($request);
        }

        // If not authenticated, go to admin login
        if (! $user) {
            return redirect()->route('admin.login');
        }

        // Authenticated but not admin — redirect to regular dashboard
        return redirect()->route('dashboard');
    }
}
