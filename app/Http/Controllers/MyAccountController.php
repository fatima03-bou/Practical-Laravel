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
        $viewData = [];
        $viewData["title"] = "My Orders - Online Store";
        $viewData["subtitle"] =  "My Orders";
        // بدل 'getId()' بـ 'id'
        $viewData["orders"] = Order::with(['items.product'])->where('user_id', Auth::user()->id)->get();
        return view('myaccount.orders')->with("viewData", $viewData);
    }
}
