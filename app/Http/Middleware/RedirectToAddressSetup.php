<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToAddressSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Only apply to authenticated users
        if (! $user) {
            return $next($request);
        }

        // Skip if user is already on address setup pages
        if ($request->routeIs('registration.*') || $request->routeIs('addresses.*')) {
            return $next($request);
        }

        // Skip if user is logging out
        if ($request->routeIs('logout')) {
            return $next($request);
        }

        // Redirect to address setup if user has no addresses
        if (! $user->hasAddresses()) {
            return redirect()->route('registration.address-setup');
        }

        return $next($request);
    }
}
