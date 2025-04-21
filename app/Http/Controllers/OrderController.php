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
    
    // Méthode existante qui affiche le formulaire de commande
    public function create()
    {
        $cart = $this->cartService->getCart(request());
        if (count($cart->getItems()) == 0) {
            return redirect()->back()->with('error', 'Votre panier est vide');
        }
        
        return view('order.create', compact('cart'));
    }
    
    // Méthode modifiée pour prendre en compte la méthode de paiement
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'payment_method' => 'required|in:livraison,en_ligne',
        ]);
        
        // Si l'utilisateur choisit le paiement en ligne, le rediriger vers la passerelle de paiement
        if ($request->payment_method == 'en_ligne') {
            // Stocker les informations de commande en session pour les récupérer après le paiement
            session()->put('order_data', [
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'payment_method' => 'en_ligne'
            ]);
            
            return redirect()->route('payment.checkout');
        }

        // Si c'est un paiement à la livraison, créer directement la commande
        $order = $this->createOrder($request, 'livraison');
        
        // Vider le panier
        $this->cartService->clear();
        
        return redirect()->route('orders.success', ['order' => $order->id])
            ->with('success', 'Votre commande a été passée avec succès. Paiement à la livraison.');
    }
    
    // Méthode modifiée pour inclure la méthode de paiement
    protected function createOrder($request, $paymentMethod, $transactionId = null)
    {
        $cart = $this->cartService->getCart(request());
        $order = new Order();
        $order->user_id = auth()->id();
        $order->address = $request->address;
        $order->city = $request->city;
        $order->postal_code = $request->postal_code;
        $order->total = $cart->getTotal();
        $order->status = 'Commandé';
        $order->payment_method = $paymentMethod;
        
        if ($transactionId) {
            $order->transaction_id = $transactionId;
        }
        
        $order->save();
        
        // Ajouter les produits à la commande et mettre à jour le stock
        foreach ($cart->getItems() as $item) {
            $product = \App\Models\Product::findOrFail($item->getId());
            
            // Créer l'item de commande
            $order->items()->create([
                'product_id' => $item->getId(),
                'quantity' => $item->getQuantity(),
                'price' => $product->getDiscountedPrice()
            ]);
            
            // Mettre à jour le stock
            $product->quantity_store -= $item->getQuantity();
            $product->save();
        }
        
        return $order;
    }
    
    // Méthode pour afficher la page de succès
    public function success(Order $order)
    {
        // Vérifier que l'utilisateur actuel est bien le propriétaire de la commande
        if ($order->user_id != auth()->id()) {
            abort(403);
        }
        
        return view('order.success', compact('order'));
    }
}