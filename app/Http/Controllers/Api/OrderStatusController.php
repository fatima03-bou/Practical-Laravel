<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function getStatus($orderId)
    {
        // On récupère la commande avec les relations "produit", "utilisateur", et "items"
        $order = Order::with(['product', 'user', 'items'])->find($orderId);

        // Si la commande n'existe pas, on renvoie une erreur 404
        if (!$order) {
            return response()->json(['error' => 'Commande non trouvée'], 404);
        }

        // On renvoie les données de la commande sous forme de JSON
        return response()->json([
            'order_id' => $order->getId(),
            'status' => $order->getStatus(),
            'total' => $order->getTotal(),
            'product' => $order->product?->name, // nom du produit lié
            'user' => $order->user?->name,       // nom de l'utilisateur
            'created_at' => $order->getCreatedAt(),
            'updated_at' => $order->getUpdatedAt(),

            // Message d'état personnalisé selon le statut
            'message' => match ($order->getStatus()) {
                'processing' => 'Votre commande est en cours de traitement 💼',
                'shipped' => 'Votre commande a été expédiée 🚚',
                'delivered' => 'Votre commande a été livrée ✅',
                'cancelled' => 'Votre commande a été annulée ❌',
                default => 'Statut inconnu',
            },

            // Liste des articles commandés (s’il y en a plusieurs)
            'items' => $order->items->map(function ($item) {
                return [
                    'name' => $item->product->name ?? 'Inconnu',
                    'quantity' => $item->quantity,
                ];
            }),
        ]);
    }
    public function showStatus($id)
    {
        $order = Order::with('product', 'user')->find($id);

        if (!$order) {
            return abort(404, 'Commande non trouvée');
        }

        return view('orders.status', compact('order'));
    }

}
