@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 mt-10">
    <div class="max-w-lg mx-auto bg-white shadow-xl rounded-xl p-8">
        <h2 class="text-3xl font-semibold text-gray-800 text-center mb-6">
            <i class="fas fa-truck text-green-600"></i> {{ __('delivery_information') }}
        </h2>

        <form action="{{ route('cart.purchase') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-800 mb-2">{{ __('name') }}</label>
                <input type="text" name="name" id="name"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition"
                       required>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-800 mb-2">{{ __('phone') }}</label>
                <input type="text" name="phone" id="phone"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition"
                       required>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-800 mb-2">{{ __('address') }} :</label>
                <textarea name="address" id="address" rows="5"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition"
                          required></textarea>
            </div>

            <input type="hidden" name="method" value="Cash on Delivery">

            <div class="text-center">
                <button type="submit"
                        class="w-full py-3 px-6 bg-green-600 hover:bg-green-700 text-white text-lg font-semibold rounded-lg shadow-md transition">
                        <i class="fas fa-check-circle"></i> {{ __('confirm_order') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
