@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="bg-gray-50 shadow-md rounded-xl p-8 mb-12">
  <h2 class="text-3xl font-bold mb-8 text-gray-800">
    <i class="fas fa-shopping-cart text-gray-700"></i> {{ __('messages.products_in_cart') }}
  </h2>

  @if (count($viewData["products"]) > 0)
    <div class="overflow-x-auto rounded-lg border border-gray-300 shadow-lg">
      <table class="min-w-full bg-white divide-y divide-gray-300">
        <thead class="bg-gray-100">
          <tr class="text-gray-800 text-left text-sm font-semibold uppercase tracking-wider">
            <th class="px-6 py-3">{{ __('messages.id') }}</th>
            <th class="px-6 py-3">{{ __('messages.name') }}</th>
            <th class="px-6 py-3">{{ __('messages.price') }}</th>
            <th class="px-6 py-3">{{ __('messages.quantity') }}</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @foreach ($viewData["products"] as $product)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 text-gray-800">{{ $product->getId() }}</td>
            <td class="px-6 py-4 text-gray-800">{{ $product->getName() }}</td>
            <td class="px-6 py-4 text-green-600 font-medium">{{ number_format($product->getPrice(), 2) }} DH</td>
            <td class="px-6 py-4 text-gray-800">{{ $viewData['productsInCookie'][$product->getId()] ?? 0 }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-8 flex flex-col items-end gap-6">
      <div class="text-xl font-semibold text-gray-800">
        <i class="fas fa-wallet text-green-600"></i> {{ __('messages.total_to_pay') }}: <span class="text-green-600">${{ $viewData["total"] }}</span>
      </div>

      <form action="{{ route('payment.add') }}" method="POST" class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="mb-5">
          <label for="payment_method" class="block text-sm font-semibold text-gray-800 mb-2">
            {{ __('messages.choose_payment_method') }}
          </label>
          <div class="flex flex-col gap-4">
            <!-- Option Cash on Delivery -->
            <label class="flex items-center space-x-3 bg-gray-100 p-4 rounded-xl shadow-sm hover:bg-gray-200 transition cursor-pointer">
              <input type="radio" name="payment_method" value="Cash on Delivery" class="hidden" required>
              <div class="flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full">
                <i class="fas fa-money-bill-wave"></i>
              </div>
              <span class="text-gray-800 font-medium text-lg">{{ __('messages.cash_on_delivery') }}</span>
            </label>
            <!-- Option Online -->
            <label class="flex items-center space-x-3 bg-gray-100 p-4 rounded-xl shadow-sm hover:bg-gray-200 transition cursor-pointer">
              <input type="radio" name="payment_method" value="Online" class="hidden" required>
              <div class="flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full">
                <i class="fas fa-credit-card"></i>
              </div>
              <span class="text-gray-800 font-medium text-lg">{{ __('messages.online') }}</span>
            </label>
          </div>
        </div>

        <div class="flex flex-col md:flex-row gap-4 justify-between">
          <button type="submit"
            class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition">
            <i class="fas fa-check-circle"></i> {{ __('messages.confirm_order') }}
          </button>
          <a href="{{ route('cart.delete') }}"
            class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition text-center">
            <i class="fas fa-trash-alt"></i> {{ __('messages.remove_all_products') }}
          </a>
        </div>
      </form>
    </div>

  @else
    <div class="text-center py-10">
      <p class="text-xl font-semibold text-gray-500">{{ __('messages.empty_cart') }}</p>
      <a href="{{ route('product.index') }}"
        class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
        <i class="fas fa-arrow-left"></i> {{ __('messages.continue_shopping') }}
      </a>
    </div>
  @endif
</div>
@endsection
