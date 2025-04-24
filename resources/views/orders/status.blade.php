@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white">
            <h4>Order #{{ $order->id }} Status</h4>
        </div>
        <div class="card-body">
            <p><strong>Status:</strong>
                @switch(strtolower($order->status))
                @case('processing')
                    <span class="text-warning">Processing 💼</span>
                    @break
                @case('shipped')
                    <span class="text-info">Shipped 🚚</span>
                    @break
                @case('delivered')
                    <span class="text-success">Delivered ✅</span>
                    @break
                @case('cancelled')
                    <span class="text-danger">Cancelled ❌</span>
                    @break
                @default
                    <span class="text-muted">Unknown</span>
            @endswitch
            
            </p>

            <p><strong>Total:</strong> ${{ $order->total }}</p>
            <p><strong>Customer:</strong> {{ $order->user->name }}</p>
            <p><strong>Created at:</strong> {{ $order->created_at->format('d M Y - H:i') }}</p>

            <hr>

            <h5>Items</h5>
            <ul class="list-group">
                @foreach($order->items as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $item->product->name ?? 'Unknown product' }}
                        <span class="badge bg-secondary">{{ $item->quantity }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
