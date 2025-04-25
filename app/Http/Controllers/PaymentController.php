<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    // في PaymentController.php
    public function showPaymentForm()
    {
        // هنا يمكن أن تعرض نموذج الدفع، على سبيل المثال:
        return view('payment.form'); // افترض أن لديك view باسم payment.form
    }

    public function handleSuccess(Request $request)
    {
        // logic to store payment info or show confirmation
        return view('payment.success');
    }
    
}