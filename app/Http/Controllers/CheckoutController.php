<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function form(Request $request): View
    {
        $cart = collect($request->session()->get('cart', []));
        $items = $cart->map(function ($item) {
            $product = Product::find($item['product_id']);
            return [
                'product' => $product,
                'quantity' => $item['quantity'],
                'subtotal' => $product ? round($product->price * $item['quantity'], 2) : 0,
            ];
        });
        $total = $items->sum('subtotal');

        return view('checkout.form', compact('items', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_email' => ['required', 'email'],
            'guest_phone' => ['nullable', 'string', 'max:50'],
            'guest_address' => ['required', 'string'],
            'delivery_location' => ['nullable', 'string', 'max:255'],
        ]);

        $cart = collect($request->session()->get('cart', []));
        if ($cart->isEmpty()) {
            return Redirect::route('cart.view')->with('status', 'Your cart is empty');
        }

        $items = $cart->map(function ($item) {
            $product = Product::lockForUpdate()->find($item['product_id']);
            return [
                'product' => $product,
                'quantity' => $item['quantity'],
                'subtotal' => $product ? round($product->price * $item['quantity'], 2) : 0,
            ];
        });
        $total = $items->sum('subtotal');

        DB::transaction(function () use ($validated, $items, $total, $request) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'guest_name' => $validated['guest_name'] ?? null,
                'guest_email' => $validated['guest_email'] ?? null,
                'guest_phone' => $validated['guest_phone'] ?? null,
                'guest_address' => $validated['guest_address'] ?? null,
                'delivery_location' => $validated['delivery_location'] ?? null,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                /** @var Product|null $product */
                $product = $item['product'];
                if (!$product) {
                    continue;
                }

                if ($product->stock < $item['quantity']) {
                    throw new \RuntimeException('Insufficient stock for ' . $product->name);
                }

                $product->decrement('stock', $item['quantity']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            $request->session()->forget('cart');
            session()->flash('order_id', $order->id);
        });

        return Redirect::route('checkout.confirmation');
    }

    public function confirmation(): View
    {
        $orderId = session()->get('order_id');
        $order = $orderId ? Order::with('items.product')->find($orderId) : null;
        return view('checkout.confirmation', compact('order'));
    }
}


