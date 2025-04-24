<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{



    public function processPaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:Cash on Delivery,Online',
        ]);

        if ($request->payment_method === 'Online') {
            return view('payment.online');
        } else {
            return view('payment.cash_payment_info');
        }
    }


}