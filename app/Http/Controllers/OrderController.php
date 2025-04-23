<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\CartService;

class OrderController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // Display the order creation form
    public function create()
    {
        $cart = $this->cartService->getCart(request());
        if (count($cart->getItems()) == 0) {
            return redirect()->back()->with('error', 'Votre panier est vide');
        }

        return view('order.create', compact('cart'));
    }

    // Handle order creation, including payment method selection
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'payment_method' => 'required|in:livraison,en_ligne',
        ]);

        // If the user chooses online payment, redirect to the payment gateway
        if ($request->payment_method == 'en_ligne') {
            // Store order data in session for later retrieval after payment
            session()->put('order_data', [
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'payment_method' => 'en_ligne'
            ]);

            return redirect()->route('payment.checkout');
        }

        // If it's cash on delivery, create the order directly
        $order = $this->createOrder($request, 'livraison');

        // Clear the cart after placing the order
        $this->cartService->clear();

        return redirect()->route('orders.success', ['order' => $order->id])
            ->with('success', 'Votre commande a été passée avec succès. Paiement à la livraison.');
    }

    // Create the order and update product stock
    protected function createOrder($request, $paymentMethod, $transactionId = null)
    {
        $cart = $this->cartService->getCart(request());
        $order = new Order();
        $order->user_id = auth()->id();
        $order->address = $request->address;
        $order->city = $request->city;
        $order->postal_code = $request->postal_code;
        $order->total = $cart->getTotal();
        $order->status = 'Commandé'; // Order placed
        $order->payment_method = $paymentMethod;

        if ($transactionId) {
            $order->transaction_id = $transactionId;
        }

        $order->save();

        // Add products to the order and update stock
        foreach ($cart->getItems() as $item) {
            $product = \App\Models\Product::findOrFail($item->getId());

            // Create order item
            $order->items()->create([
                'product_id' => $item->getId(),
                'quantity' => $item->getQuantity(),
                'price' => $product->getDiscountedPrice()
            ]);

            // Update product stock
            $product->quantity_store -= $item->getQuantity();
            $product->save();
        }

        return $order;
    }

    // Show success page for order
    public function success(Order $order)
    {
        // Ensure that the current user is the owner of the order
        if ($order->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('order.success', compact('order'));
    }
}