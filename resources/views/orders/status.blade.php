@extends('layouts.app')
@section('title', 'Order Status')
@section('subtitle', 'Your Order Status')
@section('content')
<div class="container mt-5">
    <h2>Order Status</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Status:</strong> 
                @switch($order->status)
                    @case('processing')
                        <span class="badge badge-warning">Processing</span>
                        @break
                    @case('shipped')
                        <span class="badge badge-primary">Shipped</span>
                        @break
                    @case('delivered')
                        <span class="badge badge-success">Delivered</span>
                        @break
                    @case('cancelled')
                        <span class="badge badge-danger">Cancelled</span>
                        @break
                    @default
                        <span class="badge badge-secondary">Unknown Status</span>
                @endswitch
            </p>
            <p><strong>Total:</strong> {{ $order->total }} MAD</p>
            <p><strong>Product:</strong> {{ $order->product ? $order->product->name : 'Not specified' }}</p>
            <p><strong>Updated on:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('home.index') }}" class="btn btn-secondary mt-3">Back to Home</a>
</div>
@endsection
