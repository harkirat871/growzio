<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CartController;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\GoogleSheetOrderLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /** Loyalty: 10 points = 1 currency unit (must match CartController::POINTS_PER_UNIT) */
    private const POINTS_PER_UNIT = 10;

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
        $subtotal = (float) $items->sum('subtotal');

        $loyaltyPointsToUse = 0;
        $loyaltyDiscountAmount = 0.0;
        $total = $subtotal;
        if (auth()->check()) {
            $user = auth()->user();
            $sessionPoints = (int) $request->session()->get(CartController::SESSION_LOYALTY_POINTS, 0);
            $maxAllowed = (int) $user->loyalty_points;
            $pointsToUse = min(max(0, $sessionPoints), $maxAllowed);
            $maxDiscountFromPoints = $subtotal > 0 ? min($pointsToUse / self::POINTS_PER_UNIT, $subtotal) : 0;
            $loyaltyDiscountAmount = round($maxDiscountFromPoints, 2);
            $loyaltyPointsToUse = (int) round($loyaltyDiscountAmount * self::POINTS_PER_UNIT);
            $total = round(max(0, $subtotal - $loyaltyDiscountAmount), 2);
        }

        $user = auth()->user();
        return view('checkout.form', compact(
            'items',
            'subtotal',
            'total',
            'loyaltyPointsToUse',
            'loyaltyDiscountAmount',
            'user'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = collect($request->session()->get('cart', []));
        if ($cart->isEmpty()) {
            return Redirect::route('cart.view')->with('status', 'Your cart is empty');
        }

        $user = auth()->user();
        if (! $user) {
            return Redirect::route('cart.view')->with('status', 'Please log in to checkout');
        }

        $items = $cart->map(function ($item) {
            $product = Product::lockForUpdate()->find($item['product_id']);
            return [
                'product' => $product,
                'quantity' => $item['quantity'],
                'subtotal' => $product ? round($product->price * $item['quantity'], 2) : 0,
            ];
        });
        $subtotal = (float) $items->sum('subtotal');

        $loyaltyPointsToUse = 0;
        $loyaltyDiscountAmount = 0.0;
        $sessionPoints = (int) $request->session()->get(CartController::SESSION_LOYALTY_POINTS, 0);
        $maxAllowed = (int) $user->loyalty_points;
        $pointsToUse = min(max(0, $sessionPoints), $maxAllowed);
        $maxDiscountFromPoints = $subtotal > 0 ? min($pointsToUse / self::POINTS_PER_UNIT, $subtotal) : 0;
        $loyaltyDiscountAmount = round($maxDiscountFromPoints, 2);
        $loyaltyPointsToUse = (int) round($loyaltyDiscountAmount * self::POINTS_PER_UNIT);
        $total = round(max(0, $subtotal - $loyaltyDiscountAmount), 2);

        DB::transaction(function () use ($items, $total, $loyaltyPointsToUse, $loyaltyDiscountAmount, $user, $request) {
            $order = Order::create([
                'user_id' => $user->id,
                'guest_name' => $user->name,
                'guest_email' => $user->email,
                'guest_phone' => $user->contact_number,
                'guest_address' => null,
                'delivery_location' => null,
                'total' => $total,
                'status' => 'pending',
                'loyalty_points_used' => $loyaltyPointsToUse,
                'loyalty_discount_amount' => $loyaltyDiscountAmount,
            ]);

            if ($loyaltyPointsToUse > 0) {
                $user->decrement('loyalty_points', $loyaltyPointsToUse);
            }

            foreach ($items as $item) {
                /** @var Product|null $product */
                $product = $item['product'];
                if (!$product) {
                    continue;
                }

                if ($product->stock !== null) {
                    $product->decrement('stock', $item['quantity']);
                }

                $product->update(['last_sold_at' => now()]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            $request->session()->forget('cart');
            $request->session()->forget(CartController::SESSION_LOYALTY_POINTS);
            session()->flash('order_id', $order->id);
        });

        $orderId = session('order_id');
        if ($orderId) {
            $order = Order::with('items.product')->find($orderId);
            if ($order) {
                try {
                    app(GoogleSheetOrderLogger::class)->logOrder($order);
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        }

        return Redirect::route('checkout.confirmation');
    }

    public function confirmation(): View
    {
        $orderId = session()->get('order_id');
        $order = $orderId ? Order::with('items.product')->find($orderId) : null;
        return view('checkout.confirmation', compact('order'));
    }

    public function loginRequired(): RedirectResponse
    {
        // Guests can build cart freely; only gate at checkout.
        // Send them to login and come back to cart after authentication.
        session()->flash('toast', ['type' => 'info', 'message' => 'Log in to checkout']);
        session(['url.intended' => route('cart.view')]);
        return redirect()->route('login');
    }
}


