<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected $sessionKey = 'cart';

    public function getCart(): array
    {
        return Session::get($this->sessionKey, []);
    }

    public function saveCart(array $cart): void
    {
        Session::put($this->sessionKey, $cart);
    }

    public function addItem(int $productId, int $quantity = 1): void
    {
        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }
        $this->saveCart($cart);
    }

    public function removeItem(int $productId): void
    {
        $cart = $this->getCart();
        unset($cart[$productId]);
        $this->saveCart($cart);
    }

    public function clearCart(): void
    {
        Session::forget($this->sessionKey);
    }

    public function getCartItems()
 {
    $cart = session()->get('cart', []);
    $items = [];

    foreach ($cart as $productId => $quantity) {
        $product = Product::find($productId);
        if ($product) {
            $items[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
    }

    return $items;
 }


    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getCartItems() as $item) {
            $total += $item['product']->getDiscountedPrice() * $item['quantity'];
        }
        return $total;
    }
}
