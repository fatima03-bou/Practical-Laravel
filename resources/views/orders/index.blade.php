@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-6">{{ __('Orders List') }}</h2>

    {{-- إذا لم يكن هناك أي طلبات --}}
    @if($orders->isEmpty())
        <div class="bg-blue-100 text-blue-700 p-4 rounded text-center">
            {{ __('There are no orders currently.') }}
        </div>
    @else
        @foreach($orders as $order)
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="bg-blue-500 text-white px-4 py-3 rounded-t-lg">
                <strong>{{ __('Order ID:') }}</strong> {{ $order->id }} | 
                <strong>{{ __('User:') }}</strong> {{ $order->user->name }}
            </div>

            <div class="p-4">
              
                <p><strong>{{ __('Status:') }}</strong> {{ $order->status }}</p>
                <p><strong>{{ __('Payment Method:') }}</strong> {{ $order->payment_method }}</p>
                <p><strong></p>
                    <p><strong></p>
                    <p><strong>{{ __('Total:') }}</strong> {{ number_format($order->total, 2) }} DH</p>

                @if($order->payment_method === 'Cash on Delivery')
                    <p><strong>{{ __('Name:') }}</strong> {{ $order->name }}</p>
                    <p><strong>{{ __('Phone:') }}</strong> {{ $order->phone }}</p>
                    <p><strong>{{ __('Address:') }}</strong> {{ $order->address }}</p>
                @endif

                <p><strong>{{ __('Created At:') }}</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>

                <h5 class="text-lg font-bold mt-6">{{ __('Products:') }}</h5>
                <table class="min-w-full bg-white border border-gray-200 mt-4">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">{{ __('Product') }}</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">{{ __('Quantity') }}</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">{{ __('Unit Price') }}</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $item->product->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($item->price, 2) }} DH</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($item->quantity * $item->price, 2) }} DH</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection
