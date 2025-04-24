@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="bg-white shadow-xl rounded-2xl p-6 mb-10">
  <h2 class="text-3xl font-extrabold mb-6 text-gray-800 flex items-center gap-2">
    🛒 <span>{{ __('messages.products_in_cart') }}</span>
  </h2>
  {{-- {{ dd($viewData) }} --}}

  @if (count($viewData["products"]) > 0)
  <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
    <table class="min-w-full bg-white divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr class="text-gray-700 text-left text-sm font-semibold uppercase tracking-wider">
          <th class="px-6 py-3">{{ __('messages.id') }}</th>
          <th class="px-6 py-3">{{ __('messages.name') }}</th>
          <th class="px-6 py-3">{{ __('messages.price') }}</th>
          <th class="px-6 py-3">{{ __('messages.quantity') }}</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @foreach ($viewData["products"] as $product)
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4">{{ $product->getId() }}</td>
          <td class="px-6 py-4">{{ $product->getName() }}</td>
          <td class="px-6 py-4 text-green-600 font-medium">{{ number_format($product->getPrice(), 2) }} DH</td>
          <td class="px-6 py-4">{{ $viewData['productsInCookie'][$product->getId()] ?? 0 }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-8 flex flex-col items-end gap-6">
    <div class="text-xl font-bold text-gray-800">
      💰 {{ __('messages.total_to_pay') }}: <span class="text-green-600">${{ $viewData["total"] }}</span>
    </div>
   
    <form action="{{ route('payment.add') }}" method="POST" class="w-full max-w-md">
      @csrf
     <div class="mb-5">
  <label for="payment_method" class="block text-sm font-semibold text-gray-700 mb-2">
    {{ __('messages.choose_payment_method') }}
  
  </label>
  <div class="relative">
    <select
      name="payment_method"
      id="payment_method"
      class="appearance-none w-full px-4 py-3 pr-10 border border-gray-300 bg-white text-gray-800 text-base font-medium rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
      required>
      <option value="Cash on Delivery">  {{ __('messages.cash_on_delivery') }}</option>
      <option value="Online">{{ __('messages.online') }}</option>
    </select>
    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M19 9l-7 7-7-7"></path>
      </svg>
    </div>
  </div>
</div>


      <div class="flex flex-col md:flex-row gap-4 justify-between">
        <button type="submit"
          class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition">
          ✅ {{ __('messages.confirm_order') }}
        </button>
        <a href="{{ route('cart.delete') }}"
          class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition text-center">
          🗑️ {{ __('messages.remove_all_products') }}
        </a>
      </div>
    </form>
  </div>

  @else
  <div class="text-center py-10">
    <p class="text-xl font-semibold text-gray-500">🛒 {{ __('messages.empty_cart') }}</p>
    <a href="{{ route('product.index') }}"
      class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
      🛍️ {{ __('messages.continue_shopping') }}
    </a>
  </div>
  @endif
</div>
@endsection
