<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;

class CartController extends Controller
{
    public function index(Request $request)
    {
        // Get cart from cookie (default to empty array if not set)
        $cart = json_decode($request->cookie('cart'), true) ?? [];

        // Fetch products from the cart by their IDs
        $productsInCart = !empty($cart) ? Product::findMany(array_keys($cart)) : [];
        $total = !empty($productsInCart) ? Product::sumPricesByQuantities($productsInCart, $cart) : 0;

        $viewData = [
            "title" => "Cart - Online Store",
            "subtitle" => "Shopping Cart",
            "total" => $total,
            "products" => $productsInCart
        ];

        return view('cart.index')->with("viewData", $viewData);
    }

    public function add(Product $product, Request $request)
    {
        $quantity = $request->quantity ?? 1;

        // Vérifier la disponibilité du stock
        if ($product->quantity_store < $quantity) {
            return back()->with('error', 'Quantité insuffisante en stock.');
        }

        // Obtenir le prix avec remise si applicable
        $price = $product->getDiscountedPrice();

        // Ajouter au panier (cookie ou session selon votre implémentation)
        $cart = json_decode($request->cookie('cart'), true) ?? [];  // Retrieve the cart from the cookie
        
        // Si le produit existe déjà dans le panier, on met à jour la quantité
        if (isset($cart[$product->id])) {
            $cart[$product->id] += $quantity;  // Add to the existing quantity
        } else {
            $cart[$product->id] = $quantity;  // Otherwise, add the product to the cart
        }

        // Save the updated cart back to the cookie
        return back()->withCookie(cookie('cart', json_encode($cart), 60 * 24 * 30))  // Save the cart in a cookie for 30 days
            ->with('success', 'Produit ajouté au panier.');
    }

    public function delete(Request $request)
    {
        // Clear the cart by emptying the cookie
        return back()->withCookie(cookie('cart', json_encode([]), 60 * 24 * 30))
            ->with('success', 'Cart cleared successfully.');
    }

    public function purchase(Request $request)
    {
        // Obtenir le panier de cookie
        $cart = json_decode($request->cookie('cart'), true) ?? [];

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $user = Auth::user();

        if (!$user instanceof User) {
            return back()->with('error', 'User not found.');
        }

        // Create a new order
        $order = new Order();
        $order->user_id = $user->id;
        $order->total = 0;
        $order->save();

        $total = 0;
        $productsInCart = Product::findMany(array_keys($cart));

        foreach ($productsInCart as $product) {
            $quantity = $cart[$product->id];

            // Verifier le stock avant l’achat
            if ($product->quantity_store < $quantity) {
                $order->delete();
                return redirect()->route("cart.index")->with("error", "Quantity requested for product " . $product->name . " not available in stock.");
            }

            // Update quantity in stock
            $product->quantity_store -= $quantity;
            $product->save();

            // Create order item
            $item = new Item();
            $item->quantity = $quantity;
            $item->price = $product->hasDiscount() ? $product->getDiscountedPrice() : $product->price;
            $item->product_id = $product->id;
            $item->order_id = $order->id;
            $item->save();

            $total += $item->price * $quantity;
        }

        // Verify if user has enough balance
        if ($user->balance < $total) {
            $order->delete();
            return back()->with('error', 'Insufficient funds to complete the purchase.');
        }

        // Deduct balance from user
        $user->balance -= $total;
        $user->save();

        // Update order total
        $order->total = $total;
        $order->save();

        // Clear cart by emptying the cookie
        return redirect()->route('cart.index')->withCookie(cookie('cart', json_encode([]), 60 * 24 * 30))
            ->with('success', 'Purchase completed successfully.');
    }

    // Helper Methods for Cart
    private function getCart()
    {
        return json_decode(request()->cookie('cart'), true) ?? [];
    }

    private function saveCart($cart)
    {
        return response()->withCookie(cookie('cart', json_encode($cart), 60 * 24 * 30));  // Save cart for 30 days
    }
}
