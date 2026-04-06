<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CartController extends Controller
{
    /** Loyalty: 10 points = 1 currency unit */
    public const POINTS_PER_UNIT = 10;

    /** Session key for loyalty points to use at checkout */
    public const SESSION_LOYALTY_POINTS = 'loyalty_points_to_use';

    /**
     * Build cart items array from session (shared by view and drawerData).
     */
    private function getCartItems(Request $request): array
    {
        $cart = $request->session()->get('cart', []);
        $items = [];

        foreach ($cart as $item) {
            $productId = $item['product_id'] ?? null;
            $qty = (int) ($item['quantity'] ?? 0);
            if (! $productId || $qty <= 0) {
                continue;
            }

            $product = Product::find($productId);
            if (! $product) {
                continue;
            }

            $items[] = [
                'product' => $product,
                'quantity' => $qty,
                'subtotal' => round(((float) $product->price) * $qty, 2),
            ];
        }

        return $items;
    }

    /**
     * JSON for side-cart drawer: count, items, subtotal, view_cart_url, checkout_url.
     */
    public function drawerData(Request $request): \Illuminate\Http\JsonResponse
    {
        $items = $this->getCartItems($request);
        $subtotal = (float) collect($items)->sum('subtotal');
        $count = (int) array_sum(array_column($request->session()->get('cart', []), 'quantity'));

        $drawerItems = array_map(function ($row) {
            $product = $row['product'];
            return [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $row['quantity'],
                'subtotal' => $row['subtotal'],
                'image_path' => $product->image_path ? asset($product->image_path) : null,
                'show_url' => route('products.show', $product),
                'remove_url' => route('cart.remove', $product),
            ];
        }, $items);

        return response()->json([
            'count' => $count,
            'items' => $drawerItems,
            'subtotal' => round($subtotal, 2),
            'authenticated' => Auth::check(),
            'view_cart_url' => route('cart.view'),
            'checkout_url' => Auth::check() ? route('checkout.form') : route('checkout.login-required'),
        ]);
    }

    public function view(Request $request): View
    {
        $items = $this->getCartItems($request);
        $subtotal = (float) collect($items)->sum('subtotal');

        $loyaltyPointsAvailable = 0;
        $loyaltyPointsToUse = 0;
        $loyaltyDiscountAmount = 0.0;
        $total = $subtotal;
        $remainingPoints = 0;

        if (Auth::check()) {
            $loyaltyPointsAvailable = (int) Auth::user()->loyalty_points;
            $sessionPoints = (int) $request->session()->get(self::SESSION_LOYALTY_POINTS, 0);
            $pointsToUse = min(max(0, $sessionPoints), $loyaltyPointsAvailable);
            $maxDiscountFromPoints = $subtotal > 0 ? min($pointsToUse / self::POINTS_PER_UNIT, $subtotal) : 0;
            $loyaltyDiscountAmount = round($maxDiscountFromPoints, 2);
            $loyaltyPointsToUse = (int) round($loyaltyDiscountAmount * self::POINTS_PER_UNIT);
            $total = round(max(0, $subtotal - $loyaltyDiscountAmount), 2);
            $remainingPoints = $loyaltyPointsAvailable - $loyaltyPointsToUse;
        }

        return view('cart.index', compact(
            'items',
            'subtotal',
            'total',
            'loyaltyPointsAvailable',
            'loyaltyPointsToUse',
            'loyaltyDiscountAmount',
            'remainingPoints'
        ));
    }

    /**
     * Apply or update loyalty points for checkout. Stores in session; recalc happens on view/checkout.
     */
    public function applyLoyalty(Request $request): RedirectResponse
    {
        $request->validate([
            'loyalty_points_to_use' => ['required', 'integer', 'min:0'],
        ]);
        $requested = (int) $request->input('loyalty_points_to_use');
        $user = Auth::user();
        if (!$user) {
            $request->session()->flash('toast', ['type' => 'error', 'message' => 'Log in to use points']);
            return Redirect::route('cart.view');
        }
        $maxAllowed = (int) $user->loyalty_points;
        $points = min($requested, $maxAllowed);
        $request->session()->put(self::SESSION_LOYALTY_POINTS, $points);
        $request->session()->flash('toast', ['type' => 'success', 'message' => $points > 0 ? 'Points applied' : 'Points cleared']);
        return Redirect::route('cart.view');
    }

    public function add(Request $request, Product $product): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);
        $quantity = max(1, (int)($validated['quantity'] ?? 1));

        $cart = $request->session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
            ];
        }

        $request->session()->put('cart', $cart);

        Log::info('Cart updated', [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'cart_contents' => $cart,
            'user_authenticated' => Auth::check()
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => array_sum(array_column($cart, 'quantity')),
            ]);
        }

        return Redirect::route('cart.view')->with('status', 'Product added to cart');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $request->session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = (int)$validated['quantity'];
            $request->session()->put('cart', $cart);
        }

        return Redirect::route('cart.view')->with('status', 'Cart updated');
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return Redirect::route('cart.view')->with('status', 'Item removed');
    }

    public function clear(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        $request->session()->forget(self::SESSION_LOYALTY_POINTS);
        return Redirect::route('cart.view')->with('status', 'Cart cleared');
    }

    public function mergeGuestCart(Request $request): void
    {
        $guestCart = $request->session()->get('guest_cart', []);
        $userCart = $request->session()->get('cart', []);

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
