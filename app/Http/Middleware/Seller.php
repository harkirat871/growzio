<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Seller
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isSeller()) {
            return $next($request);
        }
        abort(403, 'Seller access required');
    }
}
