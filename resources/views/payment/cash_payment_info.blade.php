@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 mt-10">
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-4">{{ __('delivery_information') }}</h2>

        <form action="{{ route('cart.purchase') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('name') }} </label>
                <input type="text" name="name" id="name"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">{{ __('phone') }}</label>
                <input type="text" name="phone" id="phone"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">{{ __('address') }} : </label>
                <textarea name="address" id="address" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                ></textarea>
            </div>

            <input type="hidden" name="method" value="Cash on Delivery">

            <div class="text-center">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-md transition">
                        {{ __('confirm_order') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
