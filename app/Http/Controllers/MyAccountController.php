<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MyAccountController extends Controller
{
    public function orders()
{
    // Récupérer les commandes avec les articles associés pour l'utilisateur connecté
    $orders = Order::with('items.product')->where('user_id', auth()->id())->get();

    // Calculer le total de chaque commande et ajouter des informations supplémentaires
    foreach ($orders as $order) {
        $order->calculated_total = $order->items->reduce(function ($total, $item) {
            // Calculer le prix total pour chaque article (prix * quantité)
            return $total + ($item->quantity * $item->price);
        }, 0);
    }

    return view('myaccount.orders', compact('orders'));
}


}
