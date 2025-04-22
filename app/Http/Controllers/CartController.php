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

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $cart = $this->getCart();
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
        if ($product->quantity_store <= 0) {
            return back()->with('error', 'Produit en rupture de stock.');
        }

        if ($product->quantity_store < $quantity) {
            return back()->with('error', 'Quantité insuffisante en stock.');
        }

        // Using CartService to handle the addition of the item
        $cookie = $this->cartService->add($request, $product->id, $quantity);

        return back()->with('success', 'Produit ajouté au panier.')->cookie($cookie);
    }

    public function delete(Request $request)
    {
        return back()->withCookie(cookie('cart', json_encode([]), 60 * 24 * 30))
            ->with('success', 'Cart cleared successfully.');
    }

    public function purchase(Request $request)
    {
        $cart = $this->getCart();

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

            if ($product->quantity_store < $quantity) {
                $order->delete();
                return redirect()->route("cart.index")
                    ->with("error", "Quantity requested for product " . $product->name . " not available in stock.");
            }

            $product->quantity_store -= $quantity;
            $product->save();

            $item = new Item();
            $item->quantity = $quantity;
            $item->price = $product->hasDiscount() ? $product->getDiscountedPrice() : $product->price;
            $item->product_id = $product->id;
            $item->order_id = $order->id;
            $item->save();

            $total += $item->price * $quantity;
        }

        if ($user->balance < $total) {
            $order->delete();
            return back()->with('error', 'Insufficient funds to complete the purchase.');
        }

        $user->balance -= $total;
        $user->save();

        $order->total = $total;
        $order->save();

        return redirect()->route('cart.index')->withCookie(cookie('cart', json_encode([]), 60 * 24 * 30))
            ->with('success', 'Purchase completed successfully.');
    }

    private function getCart()
    {
        return json_decode(request()->cookie('cart'), true) ?? [];
    }
}
