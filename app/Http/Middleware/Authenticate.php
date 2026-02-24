<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // If a guest is trying to access checkout pages, show friendly page
        if ($request->is('checkout') || $request->is('checkout/*')) {
            // remember intended URL so users return after login
            $request->session()->put('url.intended', url('/checkout'));
            return route('checkout.login-required');
        }

        return route('login');
    }
}
