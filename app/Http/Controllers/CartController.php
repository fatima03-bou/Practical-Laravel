<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Item;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $productsInSession = $request->session()->get("products");
        // verify if cart is not empty
        if ($productsInSession) {
            $userId = Auth::user()->getAuthIdentifier();

            //create new order
            $order = new Order();
            $order->setUserId($userId);
            $order->setTotal(0);
            $order->save();

            $total = 0;
            $productsInCart = Product::findMany(array_keys($productsInSession));
            foreach ($productsInCart as $product) {
                $quantity = $productsInSession[$product->getId()];


             ////UPDATE QUANTITY IN STOCK AFTER VALIDATION ACHAT
                //verify if quantity in stock est suffisante
                if ($product->getQuantityStore() < $quantity) {
                    $order->delete();
                    return redirect()->route("cart.index")
                                     ->with("error", "Quantity requested for product".$product->getName()."not available in stock ");

                }
                //update quantity in stock for product
                $product->setQuantityStore($product->getQuantityStore() - $quantity);
                $product->save();

             ////
                $item = new Item();
                $item->setQuantity($quantity);
                $item->setPrice($product->getPrice());
                $item->setProductId($product->getId());
                $item->setOrderId($order->getId());
                $item->save();
                $total = $total + ($product->getPrice()*$quantity);
            }
            //mise à jour le total de la commande
            $order->setTotal($total);
            $order->save();

            $newBalance = Auth::user()->getBalance() - $total;
            Auth::user()->setBalance($newBalance);
            Auth::user()->save();

            $request->session()->forget('products');

            $viewData = [];
            $viewData["title"] = "Purchase - Online Store";
            $viewData["subtitle"] =  "Purchase Status";
            $viewData["order"] =  $order;
            return view('cart.purchase')->with("viewData", $viewData);
        } else {
            return redirect()->route('cart.index');
        }
    }
}
