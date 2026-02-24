<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\RedirectResponse as HttpRedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show role upgrade form
     */
    // public function upgradeForm(): View|HttpRedirectResponse
    // {
    //     /** @var \App\Models\User|null $user */
    //     $user = Auth::user();
        
    //     if ($user && method_exists($user, 'isSeller') && $user->isSeller()) {
    //         return redirect()->route('seller.dashboard')->with('status', 'You are already a seller!');
    //     }
        
    //     return view('auth.upgrade-role');
    // }

    /**
     * Process role upgrade
     */
    public function upgrade(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('status', 'You are already an admin!');
        }

        // Validate minimal data; not all projects have extra columns
        $request->validate([
            'agree_terms' => ['required', 'accepted'],
        ]);

        // Update role only to avoid touching non-existent columns
        $user->update([
            'role' => 'seller',
        ]);

        return redirect()->route('admin.dashboard')->with('status', 'Congratulations! You can now manage products and orders.');
    }
}
