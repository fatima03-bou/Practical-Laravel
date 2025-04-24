<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Orders - Online Store";
        $viewData["orders"] = Order::all();
        return view('admin.Orders.index',compact('viewData'));
    }
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:Packed,Shipped,In Transit,Received,Returned,Closed',
        ]);

        // Update the status
        $order->status = $validated['status'];
        $order->save();

        // Redirect back to the orders page with a success message
        return redirect()->route('admin.order.index')->with('success', 'Order status updated successfully!');
    }
}
