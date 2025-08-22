<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CartController extends Controller
{
    public function view(Request $request): View
    {
        $cart = collect($request->session()->get('cart', []));
        $items = $cart->map(function ($item) {
            $product = Product::find($item['product_id']);
            if (!$product) {
                return null;
            }
            return [
                'product' => $product,
                'quantity' => $item['quantity'],
                'subtotal' => round($product->price * $item['quantity'], 2),
            ];
        })->filter();
        $total = $items->sum('subtotal');

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product): RedirectResponse
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
        return Redirect::route('cart.view')->with('status', 'Cart cleared');
    }
}


