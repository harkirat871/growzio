<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $gstNormalized = $request->filled('gst_number')
            ? strtoupper(preg_replace('/\s+/', '', $request->gst_number))
            : '';

        $phoneNormalized = $request->filled('contact_number')
            ? preg_replace('/\D/', '', $request->contact_number)
            : '';
        if (strlen($phoneNormalized) === 11 && str_starts_with($phoneNormalized, '0')) {
            $phoneNormalized = substr($phoneNormalized, 1);
        }
        if (strlen($phoneNormalized) === 12 && str_starts_with($phoneNormalized, '91')) {
            $phoneNormalized = substr($phoneNormalized, 2);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'business_name' => ['nullable', 'string', 'max:255'],
            'gst_number' => [
                'nullable',
                'string',
                'max:20',
                function (string $attribute, string $value, \Closure $fail) use ($gstNormalized) {
                    if ($gstNormalized === '') {
                        return;
                    }

                    if (strlen($gstNormalized) !== 15 || ! preg_match('/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/', $gstNormalized)) {
                        $fail('The GSTIN must be a valid 15-character GST number (e.g. 22AABCU9603R1Z5).');
                    }
                },
            ],
            'contact_number' => [
                'required',
                'string',
                'max:20',
                function (string $attribute, string $value, \Closure $fail) use ($phoneNormalized) {
                    if (strlen($phoneNormalized) !== 10 || ! preg_match('/^[6-9]/', $phoneNormalized)) {
                        $fail('The phone number must be a valid 10-digit Indian mobile number (e.g. 9876543210).');
                    }
                },
            ],
            'station' => ['required', 'string', 'max:255'],
            'referred_by' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'business_name' => $request->business_name,
            'gst_number' => $gstNormalized !== '' ? $gstNormalized : null,
            'contact_number' => $phoneNormalized ?: $request->contact_number,
            'station' => $validated['station'],
            'referred_by' => $request->referred_by,
        ]);

        // Loyalty signup bonus: 100 points
        $user->increment('loyalty_points', 100);

        event(new Registered($user));

        Auth::login($user);

        $request->session()->flash('toast', ['type' => 'success', 'message' => 'Account created']);

        // Merge guest cart with user cart if exists
        $this->mergeGuestCart($request);

        $intendedUrl = $request->session()->get('url.intended');
        if ($intendedUrl && str_contains($intendedUrl, '/cart')) {
            return redirect()->to($intendedUrl);
        }

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Merge guest cart with user cart after registration
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
}
