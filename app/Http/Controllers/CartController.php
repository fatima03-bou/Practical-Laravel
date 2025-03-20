<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class CartController extends Controller
{
    public function index(Request $request)
    {
        $total = 0;
        $productsInCart = [];

        $productsInSession = $request->session()->get("products");
        if ($productsInSession) {
            $productsInCart = Product::findMany(array_keys($productsInSession));
            $total = Product::sumPricesByQuantities($productsInCart, $productsInSession);
        }

        $viewData = [];
        $viewData["title"] = "Cart - Online Store";
        $viewData["subtitle"] =  "Shopping Cart";
        $viewData["total"] = $total;
        $viewData["products"] = $productsInCart;
        return view('cart.index')->with("viewData", $viewData);
    }

    public function add(Request $request, $id)
    {
        $product=Product::findOrFail($id);
        if(!$product){
            return redirect()->route('cart.index')->with('error', "Product not exist");
        }
        // récuperer quantity requested
        $quantityRequested =$request->input('quantity');
        //verify if quantity requested exists in stock 
        if ($quantityRequested > $product->getQuantityStore()) {
            return redirect()->route('product.show',['id'=>$id])->with('error','Quantity requested is superior than the quantity in stock');
         }

        $products = $request->session()->get("products");
        $products[$id] = $request->input('quantity');
        $request->session()->put('products', $products);

        return redirect()->route('cart.index');
    }

    public function delete(Request $request)
    {
        $request->session()->forget('products');
        return back();
    }

    public function purchase(Request $request)
{
    $productsInSession = session()->get("products", []);

    if (!empty($productsInSession)) {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur est bien une instance de User
        if (!$user instanceof User) {
            return back()->with('error', 'Utilisateur introuvable.');
        }

        $order = new Order();
        $order->user_id = $user->id;
        $order->total = 0;
        $order->save();

        $total = 0;
        $productsInCart = Product::findMany(array_keys($productsInSession));

        foreach ($productsInCart as $product) {
            $quantity = $productsInSession[$product->id];

            // Vérifier le stock avant de valider l'achat
            if ($product->quantity_store < $quantity) {
                return back()->with('error', "Stock insuffisant pour {$product->name}.");
            }

            // Déduire la quantité du stock
            $product->quantity_store -= $quantity;
            $product->save();

            // Créer un élément de commande
            $item = new Item();
            $item->quantity = $quantity;
            $item->price = $product->hasDiscount() ? $product->getDiscountedPrice() : $product->price;
            $item->product_id = $product->id;
            $item->order_id = $order->id;
            $item->save();

            $total += $item->price * $quantity;
        }

        // Vérifier si l'utilisateur a assez d'argent
        if ($user->balance < $total) {
            return back()->with('error', 'Fonds insuffisants pour effectuer l\'achat.');
        }

        // Déduire le solde de l'utilisateur
        $user->balance -= $total;
        $user->save(); // L'erreur "Undefined method save()" venait peut-être d'un utilisateur non trouvé

        // Mettre à jour le total de la commande
        $order->total = $total;
        $order->save();

        // Vider le panier
        session()->forget('products');

        return view('cart.purchase', [
            "title" => "Purchase - Online Store",
            "subtitle" => "Purchase Status",
            "order" => $order
        ])->with('success', 'Achat effectué avec succès.');
    }

    return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
}

}
