<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\CartService;
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    // Créer la commande et mettre à jour le stock des produits
    protected function createOrder($validatedData, $paymentMethod, $transactionId = null)
    {
        DB::beginTransaction(); // Démarrer la transaction

        try {
            // Vérifier si l'utilisateur est authentifié
            $user = auth()->user();
            if (!$user) {
                abort(403, 'Action non autorisée.');
            }

            $cart = $this->cartService->getCart(request());

            if (count($cart->getItems()) == 0) {
                return redirect()->back()->with('error', 'Votre panier est vide');
            }

            // Créer la commande
            $order = new Order();
            $order->user_id = $user->id;
            $order->address = $validatedData['address'];
            $order->city = $validatedData['city'];
            $order->postal_code = $validatedData['postal_code'];
            $order->total = $cart->getTotal();
            $order->status = 'Ordered';  // Status "Commandé"
            $order->payment_method = $paymentMethod;

            if ($transactionId) {
                $order->transaction_id = $transactionId;
            }

            $order->save();

            // Ajouter les produits au panier et mettre à jour le stock
            foreach ($cart->getItems() as $item) {
                $product = Product::findOrFail($item->getId());
                
                // Vérification de la disponibilité du produit en stock
                if ($product->quantity_store < $item->getQuantity()) {
                    DB::rollBack(); // Annuler la transaction en cas d'erreur
                    return redirect()->back()->with('error', 'Pas assez de stock pour ' . $product->name);
                }

                // Créer un élément de commande
                $order->items()->create([
                    'product_id' => $item->getId(),
                    'quantity' => $item->getQuantity(),
                    'price' => $product->getDiscountedPrice(),
                    'status' => 'Ordered'  // Status de l'élément de commande
                ]);

                // Mise à jour du stock du produit
                Log::info('Stock avant mise à jour: ' . $product->quantity_store);
                $product->quantity_store -= $item->getQuantity();
                Log::info('Stock après mise à jour: ' . $product->quantity_store);

                $product->save(); // Sauvegarder la mise à jour du produit
            }

            DB::commit(); // Confirmer la transaction
            return $order;
        } catch (\Exception $e) {
            DB::rollBack(); // Annuler la transaction en cas d'exception
            Log::error('Erreur lors de la création de la commande: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue, veuillez réessayer.');
        }
    }

    // Stocker la commande
    public function store(Request $request)
    {
        // Validation des données de la commande
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',  // Validation du code postal
            'payment_method' => 'required|in:livraison,en_ligne',  // Validation du mode de paiement
        ]);

        // Si le paiement en ligne est choisi
        if ($request->payment_method == 'en_ligne') {
            // Sauvegarder les informations de commande dans la session pour un paiement ultérieur
            session()->put('order_data', [
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'postal_code' => $validatedData['postal_code'],
                'payment_method' => 'en_ligne'
            ]);

            return redirect()->route('payment.checkout');
        }

        // Si paiement à la livraison, créer directement la commande
        $order = $this->createOrder($validatedData, 'livraison');

        // Vider le panier après la commande
        $this->cartService->clear();

        return redirect()->route('orders.success', ['order' => $order->id])
            ->with('success', 'Votre commande a été passée avec succès. Paiement à la livraison.');
    }

    // Afficher la page de succès de la commande
    public function success(Order $order)
    {
        // Récupérer les informations de paiement depuis la session
        $paymentDetails = session('paymentDetails', []);
        
        // Charger les articles de la commande avec les détails des produits
        $orderItems = $order->items()->with('product')->get();

        return view('payment.success', compact('order', 'paymentDetails', 'orderItems'));
    }

    // Afficher l'historique des commandes de l'utilisateur
    public function index()
    {
        // Récupérer les commandes avec les articles et leurs produits associés
        $orders = Order::with('items.product')->where('user_id', auth()->id())->get();
        return view('orders.index', compact('orders'));
    }

    // Méthode pour afficher les commandes (en ajoutant une vérification sur les items)
    public function orders()
    {
        // Récupérer les commandes avec les articles associés pour l'utilisateur connecté
        $orders = Order::with('items.product')->where('user_id', auth()->id())->get();
        
        // Afficher les commandes avec les articles
        dd($orders->map(function($order) {
            return $order->items;  // Vérifier les items de chaque commande
        }));

        return view('myaccount.orders', compact('orders'));
    }

}
