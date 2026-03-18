<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            Log::info('AdminMiddleware check: user=' . Auth::user()->Email . ' role=' . Auth::user()->role);
            if (Auth::user()->role === 'admin') {
                return $next($request);
            }
            Log::info('AdminMiddleware: User is NOT an admin. Redirecting to /');
        } else {
            Log::info('AdminMiddleware: User NOT logged in. Redirecting to /');
        }

        return redirect('/')->with('error', 'You do not have administrative access.');
    }
}
