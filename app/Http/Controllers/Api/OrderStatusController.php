<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    // الحصول على حالة الطلب
    public function getStatus($orderId)
    {
        // البحث عن الطلب باستخدام الـ ID وإحضار العلاقات اللازمة مثل المنتج، المستخدم، والعناصر
        $order = Order::with(['product', 'user', 'items'])->find($orderId);

        // إذا لم نجد الطلب، نرجع خطأ 404
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // إرجاع البيانات المطلوبة بصيغة JSON
        return response()->json([
            'order_id' => $order->id,
            'status' => $order->status,
            'total' => $order->total,
            'product' => $order->product->name ?? 'No product specified',
            'user' => $order->user->name ?? 'Unknown user',
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
            'message' => match ($order->status) {
                'processing' => 'Your order is being processed 💼',
                'shipped' => 'Your order has been shipped 🚚',
                'delivered' => 'Your order has been delivered ✅',
                'cancelled' => 'Your order has been cancelled ❌',
                default => 'Unknown status',
            },
            'items' => $order->items->map(function ($item) {
                return [
                    'name' => $item->product->name ?? 'Unknown product',
                    'quantity' => $item->quantity,
                ];
            }),
        ]);
    }
    public function showStatus($id)
    {
        $order = Order::with('product', 'user')->find($id);

        if (!$order) {
            return abort(404, 'Order not found');
        }

        return view('orders.status', compact('order'));
    }


}
