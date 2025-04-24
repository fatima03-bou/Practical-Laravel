<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity', 1);

        // If there's no active order, create one
        $order = Order::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'pending']
        );

        // Check if the product is already in the cart
        $item = Item::where('order_id', $order->id)
                    ->where('product_id', $product->id)
                    ->first();

        if ($item) {
            // If item exists, update the quantity
            $item->quantity += $quantity;
            $item->price = $product->getDiscountedPrice();
            $item->save();
        } else {
            // If item does not exist, create a new one
            Item::create([
                'quantity' => $quantity,
                'price' => $product->getDiscountedPrice(),
                'order_id' => $order->id,
                'product_id' => $product->id,
            ]);
        }

        return redirect()->route('cart.index');
    }

    public function viewCart()
    {
        $order = Order::where('user_id', Auth::id())
                      ->where('status', 'pending')
                      ->first();

        if (!$order) {
            return view('cart.index', ['message' => 'Your cart is empty.']);
        }

        $items = $order->items;
        $total = $order->getTotalPrice();

        return view('cart.index', compact('items', 'total'));
    }

    public function updateCart(Request $request)
    {
        $order = Order::where('user_id', Auth::id())
                      ->where('status', 'pending')
                      ->first();

        foreach ($request->input('items') as $itemId => $quantity) {
            $item = Item::find($itemId);
            if ($item && $item->order_id == $order->id) {
                $item->quantity = $quantity;
                $item->save();
            }
        }

        return redirect()->route('cart.index');
    }

    public function removeFromCart($itemId)
    {
        $order = Order::where('user_id', Auth::id())
                      ->where('status', 'pending')
                      ->first();

        $item = Item::find($itemId);
        if ($item && $item->order_id == $order->id) {
            $item->delete();
        }

        return redirect()->route('cart.index');
    }

    public function checkout()
    {
        $order = Order::where('user_id', Auth::id())
                      ->where('status', 'pending')
                      ->first();

        if (!$order || $order->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Update order status to 'completed' or proceed to payment...
        $order->status = 'completed';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Your order has been placed!');
    }
}
