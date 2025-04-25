<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $total = 0;
        $productsInCart = [];

        // Retrieve products stored in the cookie
        $productsInCookie = json_decode($request->cookie("products"), true) ?? [];

        // Fetch the products based on the IDs in the cookie
        if ($productsInCookie) {
            $productsInCart = Product::findMany(array_keys($productsInCookie));

            // Calculate total price based on quantities in the cookie
            $total = Product::sumPricesByQuantities($productsInCart, $productsInCookie);
        }

        // Pass data to the view
        $viewData = [];
        $viewData["title"] = "Cart - Online Store";
        $viewData["subtitle"] = "Shopping Cart";
        $viewData["total"] = $total;
        $viewData["products"] = $productsInCart;
        $viewData["productsInCookie"] = $productsInCookie;

        return view('cart.index')->with("viewData", $viewData);
    }

    public function add(Request $request, $id)
    {
        // Retrieve existing products from cookie
        $products = json_decode($request->cookie("products"), true) ?? [];

        // Check if the product already exists in the cart and update the quantity
        if (isset($products[$id])) {
            $products[$id] += $request->input('quantity');
        } else {
            $products[$id] = $request->input('quantity');
        }

        // Store updated products in the cookie
        cookie()->queue(cookie("products", json_encode($products), 60 * 24 * 7));

        return redirect()->route('cart.index');
    }

    public function delete(Request $request)
    {
        // Clear the products cookie
        cookie()->queue(cookie("products", "", -1));
        return back();
    }

    public function purchase(Request $request)
{
    $productsInCookie = json_decode($request->cookie("products"), true) ?? [];

    if ($productsInCookie) {
        $total = 0;  // تأكد من أن المتغير $total مبدئيًا يحتوي على 0

        $userId = Auth::user()->id; // Get the logged-in user's ID

        // قم بحفظ الطلب أولاً حتى نحصل على order_id
        $order = new Order();
        $order->user_id = $userId;
        $order->total = $total; // إضافة total إلى الطلب
        $order->save(); // حفظ الطلب أولًا

        // حساب إجمالي السعر بناءً على المنتجات في السلة
        $productsInCart = Product::findMany(array_keys($productsInCookie));

        foreach ($productsInCart as $product) {
            $quantity = $productsInCookie[$product->id];

            $total += $product->price * $quantity; // إضافة السعر الإجمالي

            $item = new Item();
            $item->quantity = $quantity;
            $item->price = $product->price;
            $item->product_id = $product->id; // تعيين product_id
            $item->order_id = $order->id; // تعيين order_id بعد حفظ الطلب
            $item->save(); // حفظ العنصر في قاعدة البيانات
        }

        // تحديث قيمة total بعد حساب الإجمالي
        $order->total = $total;
        $order->save(); // حفظ الطلب بعد التحديث

        return back(); // أي إجراءات أخرى هنا (مثل التحويل إلى صفحة الدفع)
    }
}


}
