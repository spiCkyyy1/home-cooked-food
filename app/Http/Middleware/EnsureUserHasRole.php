<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (is_null($request->user())) {
            return redirect()->route('login');
        }
        if ($request->user()->hasRole('Admin')) {
            return redirect()->route('dashboard');
        }
        if ($request->user()->hasRole('Vendor')) {
            if (! $request->user()->hasVerifiedEmail()) {
                return redirect()->route('profile.edit');
            }

            return redirect()->route('menu');
        }
        if ($request->user()->hasRole('Customer')) {
            return $next($request);
            //            return redirect()->route('home');
        }

    }
}
