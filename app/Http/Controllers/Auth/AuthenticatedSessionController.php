<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $request->session()->flash('toast', ['type' => 'success', 'message' => 'Logged in']);

        $user = Auth::user();
        if ($user instanceof User) {
            $user->forceFill(['last_login' => now()])->save();
        }

        // Merge guest cart with user cart if exists
        $this->mergeGuestCart($request);

        // If the intended URL is checkout, send them there; otherwise role-aware default
        $intendedUrl = $request->session()->get('url.intended');
        if ($intendedUrl) {
            if (str_contains($intendedUrl, '/checkout')) {
                return redirect()->to(url('/checkout'));
            }
            if (str_contains($intendedUrl, '/cart')) {
                return redirect()->to($intendedUrl);
            }
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Merge guest cart with user cart after login
     */
    private function mergeGuestCart(Request $request): void
    {
        $guestCart = $request->session()->get('guest_cart', []);
        $userCart = $request->session()->get('cart', []);

        if (!empty($guestCart)) {
            foreach ($guestCart as $productId => $item) {
                if (isset($userCart[$productId])) {
                    $userCart[$productId]['quantity'] += $item['quantity'];
                } else {
                    $userCart[$productId] = $item;
                }
            }

            $request->session()->put('cart', $userCart);
            $request->session()->forget('guest_cart');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
