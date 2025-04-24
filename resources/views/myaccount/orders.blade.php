@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="max-w-4xl mx-auto mt-10">

  @forelse ($viewData["orders"] as $order)
  <div class="bg-white rounded-lg shadow-md mb-6 p-6">
    <div class="flex justify-between items-center border-b pb-2 mb-4">
      <h2 class="text-lg font-semibold text-gray-800">
        {{ __('messages.order') }} #{{ $order->getId() }}
      </h2>
      <span class="text-sm text-gray-500">
        {{ __('Date:') }} {{ $order->getCreatedAt() }}
      </span>
    </div>

    <div class="mb-4 text-gray-700">
      <p><strong>{{ __('messages.total') }}:</strong> ${{ number_format($order->getTotal(), 2) }}</p>
    </div>

    {{-- Order Items Table --}}
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-center border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border">{{ __('messages.item_id') }}</th>
            <th class="p-2 border">{{ __('messages.product_name') }}</th>
            <th class="p-2 border">{{ __('messages.price') }}</th>
            <th class="p-2 border">{{ __('messages.quantity') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($order->getItems() as $item)
          <tr class="hover:bg-gray-50">
            <td class="p-2 border">{{ $item->getId() }}</td>
            <td class="p-2 border">
              <a href="{{ route('product.show', ['id'=> $item->getProduct()->getId()]) }}"
                 class="text-blue-600 hover:underline">
                {{ $item->getProduct()->getName() }}
              </a>
            </td>
            <td class="p-2 border">${{ number_format($item->getPrice(), 2) }}</td>
            <td class="p-2 border">{{ $item->getQuantity() }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  @empty
  <div class="bg-red-100 text-red-700 p-4 rounded-md text-center">
    {{ __('messages.no_purchases') }}
  </div>
  @endforelse

</div>
@endsection
