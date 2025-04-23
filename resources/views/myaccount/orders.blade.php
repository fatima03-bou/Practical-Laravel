@extends('layouts.app')
@section('title', 'My Orders')
@section('subtitle', 'Order History')
@section('content')
@forelse ($viewData["orders"] as $order)
<div class="card mb-4">
    <div class="card-header">
        Order #{{ $order->getId() }}
    </div>
    <div class="card-body">
        <b>Date:</b> {{ $order->getCreatedAt() }}<br />
        <b>Total:</b> ${{ $order->getTotal() }}<br />
        <b>Status:</b> 
        @switch($order->getStatus())
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
        <br />

        <table class="table table-bordered table-striped text-center mt-3">
            <thead>
                <tr>
                    <th scope="col">Item ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->getItems() as $item)
                <tr>
                    <td>{{ $item->getId() }}</td>
                    <td>
                        <a class="link-success" href="{{ route('product.show', ['id'=> $item->getProduct()->getId()]) }}">
                            {{ $item->getProduct()->getName() }}
                        </a>
                    </td>
                    <td>${{ $item->getPrice() }}</td>
                    <td>{{ $item->getQuantity() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="alert alert-danger" role="alert">
  It seems that you have not purchased anything in our store.
</div>
@endforelse
@endsection
