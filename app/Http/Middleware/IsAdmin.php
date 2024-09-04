<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Check for user type
            if ($user->user_type == 'admin') {
                return $next($request); // Allow user access to user routes
            } else {
                abort(403); // Unauthorized access (wrong role or incorrect route)
            }
        } else {
            return redirect('/login'); // User not logged in, redirect to login
        }
    }
}
