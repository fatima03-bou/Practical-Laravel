<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
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
        $cartItems = $this->cartService->getCart($request); // Assumed to return a collection or array

        // Set your Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];

        foreach ($cartItems as $item) {
            // Retrieve full product details
            $product = Product::findOrFail($item->id);

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => ($product->getDiscountedPrice() ?? $product->price) * 100, // Convert to cents
                ],
                'quantity' => $item->quantity,
            ];
        }

        // Create Stripe checkout session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);

        // Redirect user to Stripe's checkout page
        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        // TODO: Create the order in your database
        // TODO: Fetch session data from Stripe to get payment details
        // TODO: Update stock quantities
        // TODO: Deduct user balance if necessary

        return view('payment.success');
    }

    public function cancel()
    {
        return view('payment.cancel');
    }
}
