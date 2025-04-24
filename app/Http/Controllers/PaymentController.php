<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\CartService;

class PaymentController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function checkout(Request $request)
    {
        // Get cart items from cookies using CartService
        $cartItems = $this->cartService->getCart($request); // Must return a collection or array

        // Logic to process the order directly (no Stripe involved)
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $product = Product::findOrFail($item->id);
            $totalAmount += ($product->getDiscountedPrice() ?? $product->price) * $item->quantity;
        }

        // Create an order directly (assuming you have an Order model)
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
            'status' => 'pending', // Default status before payment
        ]);

        // Store order in database and redirect to the success page
        return redirect()->route('payment.success', ['order' => $order->id]);
    }

    public function success(Request $request)
    {
        // Check if 'order' exists in the query string
        $orderId = $request->get('order');

        if (!$orderId) {
            abort(400, 'Order ID is required');
        }

        // Retrieve the order from the database
        $order = Order::findOrFail($orderId);

        // Fetch payment details from the session
        $paymentDetails = $request->session()->get('paymentDetails', []);

        // Get order items (products) for the order
        $orderItems = $order->items; // Assuming you have a relation 'items' for products

        // Calculate delivery date (assuming it's a fixed date after a few days)
        $deliveryDate = now()->addDays(3); // 3 days for example

        // Pass order, payment details, order items, and delivery date to the view
        return view('payment.success', compact('paymentDetails', 'order', 'orderItems', 'deliveryDate'));
    }

    public function cancel()
    {
        return view('payment.cancel');
    }

    public function showPaymentForm()
    {
        return view('payment.form'); // Or your desired view
    }

    public function processPayment(Request $request)
    {
        // Validation des entrées en fonction de la méthode de paiement
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'country' => 'required|string',
            'payment_method' => 'required|string',
            // Valider card_number seulement si la méthode de paiement est en ligne
            'card_number' => 'nullable|string|required_if:payment_method,online',
            'expiry_date' => 'nullable|string|required_if:payment_method,online',
            'cvv' => 'nullable|string|required_if:payment_method,online',
        ]);
    
        // Logique pour déterminer le statut de la commande
        $orderStatus = ($validated['payment_method'] === 'online') ? 'paid' : 'pending';
    
        // Calculer le montant total en fonction des produits dans le panier
        $total = 0;
        $cartItems = $this->cartService->getCart($request);
        foreach ($cartItems as $item) {
            $product = Product::findOrFail($item->id);
            $total += $product->getDiscountedPrice() * $item->quantity;
        }
    
        // Créer la commande
        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $total, // Montant calculé basé sur les produits
            'status' => $orderStatus,
        ]);
    
        // Ajouter les produits à la commande dans la table order_items
        foreach ($cartItems as $item) {
            $product = Product::findOrFail($item->id);
            
            // Ajouter un enregistrement dans la table order_items
            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $item->quantity,
                'price' => $product->getDiscountedPrice(),
            ]);
        }
    
        // Stocker les détails de paiement si nécessaire
        $paymentDetails = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'zip' => $validated['zip'],
            'country' => $validated['country'],
        ];
    
        // Rediriger vers la page de succès avec les détails de paiement
        return redirect()->route('payment.success', ['order' => $order->id])
                         ->with('paymentDetails', $paymentDetails);
    }
    
    
}
