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
    public function index()
    {
        $productsInSession = session()->get("products", []);

        $productsInCart = !empty($productsInSession) ? Product::findMany(array_keys($productsInSession)) : [];
        $total = !empty($productsInCart) ? Product::sumPricesByQuantities($productsInCart, $productsInSession) : 0;

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
        $quantityRequested = $request->input('quantity');

        // Verify if quantity requested exists in stock
        if ($quantityRequested > $product->getQuantityStore()) {
            return redirect()->route('product.show', ['id' => $product->id])->with('error', 'Quantity requested is superior than the quantity in stock');
        }

        // Add to cart (session)
        $cart = session()->get("products", []);
        $cart[$product->id] = isset($cart[$product->id]) ? $cart[$product->id] + $quantityRequested : $quantityRequested;
        session()->put("products", $cart);

        return back()->with('success', 'Product added to cart.');
    }

    public function delete(Request $request)
    {
        $request->session()->forget('products');
        return back()->with('success', 'Cart cleared successfully.');
    }

    public function purchase(Request $request)
    {
        $productsInSession = session()->get("products", []);

        if (empty($productsInSession)) {
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
        $productsInCart = Product::findMany(array_keys($productsInSession));

        foreach ($productsInCart as $product) {
            $quantity = $productsInSession[$product->id];

            // Verify stock before purchase
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

        // Clear cart
        session()->forget('products');

        return view('cart.purchase', [
            "title" => "Purchase - Online Store",
            "subtitle" => "Purchase Status",
            "order" => $order
        ])->with('success', 'Purchase completed successfully.');
    }
}