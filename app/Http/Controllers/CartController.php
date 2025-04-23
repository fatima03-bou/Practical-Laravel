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
        // Get cart from cookie (default to empty array if not set)
        $cart = json_decode($request->cookie('cart'), true) ?? [];

        // Fetch products from the cart by their IDs
        $productsInCart = !empty($cart) ? Product::findMany(array_keys($cart)) : [];
        $total = !empty($productsInCart) ? Product::sumPricesByQuantities($productsInCart, $cart) : 0;
        $quantities = $cart; // same as json_decode($request->cookie('cart'), true)

        $viewData = [
            "title" => "Cart - Online Store",
            "subtitle" => "Shopping Cart",
            "total" => $total,
            "products" => $productsInCart,
            "quantities" => $quantities,
        ];
        

        return view('cart.index')->with("viewData", $viewData);
    }

    public function add(Request $request, $id)
    {
        // $products = $request->session()->get("products");
        $products = json_decode($request->cookie("products"), true) ?? [];
        $products[$id] = $request->input('quantity');
        // $request->session()->put('products', $products);
        cookie()->queue(cookie("cart", json_encode($products), 60 * 24 * 7));


        return redirect()->route('cart.index');
    }

    public function delete(Request $request)
    {
        // $request->session()->forget('products');
        cookie()->queue(cookie("cart", "", -1));
        return back();
    }

    

    public function purchase(Request $request)
    {
        // Get products from cookie
        $productsInCookie = json_decode($request->cookie("products"), true) ?? [];
        
        if ($productsInCookie) {
            // Get the user ID
            $userId = Auth::user()->id;  // Use $userId = Auth::user()->id
            
            // Create a new order
            $order = new Order();
            $order->user_id = $userId;  // Direct assignment
            $order->total = 0;  // Direct assignment
            $order->save();
        
            // Calculate the total price
            $total = 0;
            $productsInCart = Product::findMany(array_keys($productsInCookie));
        
            foreach ($productsInCart as $product) {
                $quantity = $productsInCookie[$product->id];  // Use $product->id
                
                // Create an item for each product (not the order)
                $item = new Item();
                $item->quantity = $quantity;  // Direct assignment
                $item->price = $product->price;  // Direct assignment
                $item->product_id = $product->id;  // Direct assignment (this should be in `items` table)
                $item->order_id = $order->id;  // Use $order->id
                $item->save();
        
                // Update the product stock
                $product->quantity_store -= $quantity;
                $product->save();
        
                // Update the total
                $total += $product->price * $quantity;
            }
        
            // Update the order's total
            $order->total = $total;  // Direct assignment
            $order->save();
        
            // Update the user's balance
            $newBalance = Auth::user()->balance - $total;  // Use Auth::user()->balance
            Auth::user()->balance = $newBalance;  // Update balance directly
            Auth::user()->save();
        
            // Clear the cart cookie
            cookie()->queue(cookie("products", "", -1));
        
            // Return the purchase view with order data
            $viewData = [];
            $viewData["title"] = "Purchase - Online Store";
            $viewData["subtitle"] = "Purchase Status";
            $viewData["order"] = $order;
        
            return view('cart.purchase')->with("viewData", $viewData);
        } else {
            return redirect()->route('cart.index');
        }
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
