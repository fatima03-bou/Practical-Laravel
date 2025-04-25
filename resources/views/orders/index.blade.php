@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-12 px-6">
    <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-10">{{ __('Orders List') }}</h2>

    {{-- No orders message --}}
    @if($orders->isEmpty())
        <div class="bg-indigo-50 text-indigo-700 p-6 rounded-lg shadow-md text-center">
            {{ __('There are no orders currently.') }}
        </div>
    @else
        @foreach($orders as $order)
        <div class="bg-white shadow-lg rounded-lg mb-10 p-8">
            <div class="bg-gradient-to-r from-indigo-500 via-blue-500 to-teal-500 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                <div>

                    <p class="text-sm">{{ __('User:') }} {{ $order->user->name }}</p>
                </div>
                <div class="text-sm font-medium">
                    <span class="bg-indigo-600 px-3 py-1 rounded-full">{{ __('Status:') }} {{ $order->status }}</span>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <p class="text-lg text-gray-800"><strong>{{ __('Payment Method:') }}</strong> {{ $order->payment_method }}</p>
                    <p class="text-lg text-gray-800"><strong>{{ __('Total:') }}</strong> {{ number_format($order->total, 2) }} DH</p>

                    @if($order->payment_method === 'Cash on Delivery')
                    <div>
                        <p class="text-lg text-gray-800"><strong>{{ __('Name:') }}</strong> {{ $order->name }}</p>
                        <p class="text-lg text-gray-800"><strong>{{ __('Phone:') }}</strong> {{ $order->phone }}</p>
                        <p class="text-lg text-gray-800"><strong>{{ __('Address:') }}</strong> {{ $order->address }}</p>
                    </div>
                    @endif

                    <p class="text-lg text-gray-800"><strong>{{ __('Created At:') }}</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                </div>

                <h5 class="text-xl font-semibold mt-6 text-gray-900">{{ __('Products:') }}</h5>
                <table class="min-w-full bg-white border border-gray-200 mt-6 rounded-lg shadow-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">{{ __('Product') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">{{ __('Quantity') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">{{ __('Unit Price') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->product->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($item->price, 2) }} DH</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($item->quantity * $item->price, 2) }} DH</td>
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
