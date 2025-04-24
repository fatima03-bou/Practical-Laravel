@extends('layouts.app')
@section('title', $viewData["title"])
@section('content')

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Bannière principale -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center">
                <div class="p-10">
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ __('messages.welcome_store') }}</h1>
                    <p class="text-gray-600 text-lg mb-6">
                        {{ __('messages.store_intro') }}
                    </p>
                    <a href="{{ route('product.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition">
                        {{ __('messages.shop_now') }}
                    </a>
                </div>
                <div class="hidden md:block">
                    <img src="https://source.unsplash.com/600x400/?shopping,store" alt="store" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <!-- Fonctionnalités de la boutique -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center mb-16">
            <div class="bg-white p-8 rounded-xl shadow hover:shadow-md transition">
                <div class="text-blue-500 text-4xl mb-4">🛒</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ __('messages.diverse_products') }}</h3>
                <p class="text-gray-600">{{ __('messages.diverse_products_desc') }}</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow hover:shadow-md transition">
                <div class="text-green-500 text-4xl mb-4">🚚</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ __('messages.fast_delivery') }}</h3>
                <p class="text-gray-600">{{ __('messages.fast_delivery_desc') }}</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow hover:shadow-md transition">
                <div class="text-yellow-500 text-4xl mb-4">💳</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ __('messages.payment_options') }}</h3>
                <p class="text-gray-600">{{ __('messages.payment_options_desc') }}</p>
            </div>
        </div>

        <!-- Appel à l'inscription -->
        <div class="bg-blue-600 text-white text-center p-10 rounded-2xl">
            <h2 class="text-3xl font-bold mb-3">{{ __('messages.join_now') }}</h2>
            <p class="text-lg mb-6">{{ __('messages.join_now_desc') }}</p>
            <a href="{{ route('register') }}" class="inline-block bg-white text-blue-600 font-semibold px-6 py-3 rounded-lg shadow hover:bg-gray-100 transition">
                {{ __('messages.register_now') }}
            </a>
        </div>

    </div>
</div>
@endsection
