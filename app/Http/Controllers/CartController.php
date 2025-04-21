<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;
use App\Services\CartService; 

class CartController extends Controller
{
    private $cartService; 
    
    // Modified constructor to inject the CartService
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

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

    // Modified add method to use CartService
    public function add(Product $product, Request $request)
    {
        if ($product->quantity_store <= 0) {
            return redirect()->back()->with('error', 'Produit en rupture de stock');
        }

        // Using CartService to handle the addition of the item
        $cookie = $this->cartService->add($request, $product->id);

        return back()->with('success', 'Produit ajouté au panier')->cookie($cookie);
    }

    public function delete(Request $request)
    {
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
}
