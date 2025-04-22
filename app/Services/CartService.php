<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Product;

class CartService
{
    private $cookieName = 'shopping_cart';
    private $cookieExpire = 60 * 24 * 30; // 30 jours
    
    public function getCart(Request $request)
    {
        $cartItems = json_decode($request->cookie($this->cookieName), true) ?? [];
        $items = collect();
        
        foreach ($cartItems as $id => $quantity) {
            $product = Product::find($id);
            if ($product) {
                $items->put($id, (object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->getDiscountedPrice(),
                    'quantity' => $quantity,
                    'image' => $product->image
                ]);
            }
        }
        
        return $items;
    }
    
    public function add(Request $request, $id, $quantity = 1)
    {
        $cartItems = json_decode($request->cookie($this->cookieName), true) ?? [];
        
        if (isset($cartItems[$id])) {
            $cartItems[$id] += $quantity;
        } else {
            $cartItems[$id] = $quantity;
        }
        
        return cookie($this->cookieName, json_encode($cartItems), $this->cookieExpire);
    }
    
    public function remove(Request $request, $id)
    {
        $cartItems = json_decode($request->cookie($this->cookieName), true) ?? [];
        
        if (isset($cartItems[$id])) {
            unset($cartItems[$id]);
        }
        
        return cookie($this->cookieName, json_encode($cartItems), $this->cookieExpire);
    }
    
    public function clear()
    {
        return cookie($this->cookieName, json_encode([]), $this->cookieExpire);
    }
}