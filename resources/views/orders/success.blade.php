@extends('layouts.app')

@section('title', 'Order Success')
@section('subtitle', 'Order Details')

@section('content')
<div class="container mt-5">
    <h2>Order Confirmation</h2>
    
    <div class="card">
        <div class="card-header">
            Order #{{ $order->id }} - Status: {{ $order->status }}
        </div>
        <div class="card-body">
            <div class="alert alert-success" role="alert">
                Your order has been successfully placed! 🎉
            </div>

            <table class="table table-bordered">
                <tr>
                    <th>Status</th>
                    <td>{{ $order->status }}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>{{ $order->total }} MAD</td>
                </tr>
                <tr>
                    <th>Payment Method</th>
                    <td>{{ $order->payment_method == 'livraison' ? 'Cash on Delivery' : 'Online Payment' }}</td>
                </tr>
                <tr>
                    <th>Delivery Address</th>
                    <td>{{ $order->address }}, {{ $order->city }}, {{ $order->postal_code }}</td>
                </tr>
            </table>

            <div class="alert alert-info">
                @switch($order->status)
                    @case('processing')
                        Your order is being processed 💼
                        @break
                    @case('shipped')
                        Your order has been shipped 🚚
                        @break
                    @case('delivered')
                        Your order has been delivered ✅
                        @break
                    @case('cancelled')
                        Your order has been cancelled ❌
                        @break
                    @default
                        Unknown status
                @endswitch
            </div>

            <a href="{{ route('home.index') }}" class="btn btn-secondary mt-3">Back to Home</a>
        </div>
    </div>
</div>
@endsection
