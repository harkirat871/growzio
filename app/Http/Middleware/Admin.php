<?php

namespace App\Http\Middleware; 

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Admin-only gate.
     *
     * Auth::user() returns an instance of `App\Models\User`.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            abort(403, 'Unauthorized');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $next($request);
        }
        abort(403, 'Unauthorized');
    }
}
