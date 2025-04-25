@extends('layouts.app')
@section('title', $viewData["title"])
@section('content')

<div class="bg-gradient-to-b from-white to-blue-50 min-h-screen pt-16 pb-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Hero Section -->
        <div class="flex flex-col-reverse md:flex-row items-center gap-12 mb-20">
            <div class="md:w-1/2 animate-fade-in-left">
                <h1 class="text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                    {{ __('Découvrez les tendances') }}
                </h1>
                <p class="text-gray-600 text-lg mb-6">
                    {{ __('Des articles stylés, des prix imbattables. Rejoignez une nouvelle ère du shopping.') }}
                </p>
                <a href="{{ route('product.index') }}" class="inline-block bg-black text-white px-8 py-3 rounded-xl text-lg font-semibold hover:bg-gray-900 transition">
                    {{ __('Explorer la boutique') }}
                </a>
            </div>
            <div class="md:w-1/2 animate-fade-in-right">
                <img src="{{ asset('storage/images/6.jpg') }}" class="rounded-3xl shadow-xl object-cover w-full h-56" alt="Hero image">
            </div>
        </div>

        <!-- Nouveautés / Collections -->
        <div class="mb-20">
            <h2 class="text-3xl font-bold text-gray-800 mb-10 text-center">{{ __('Nouvelles collections') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach (range(1,3) as $i)
                    <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 text-center">
                        <img src="{{ asset('storage/images/' . $i . '.jpg') }}" alt="Produit {{ $i }}" class="rounded-xl mb-4 w-full h-56 object-cover bg-gray-100">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('Produit tendance ') . $i }}</h3>
                        <p class="text-gray-600">{{ __('Découvrez notre sélection exclusive pour cette saison.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Section Services -->
        <div class="bg-white rounded-3xl shadow-lg p-10 mb-20">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-10">{{ __('Pourquoi choisir notre boutique ?') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-4xl mb-4 text-indigo-500">📦</div>
                    <h4 class="font-semibold text-lg text-gray-800 mb-2">{{ __('Livraison rapide') }}</h4>
                    <p class="text-gray-600">{{ __('Recevez vos commandes en un temps record.') }}</p>
                </div>
                <div>
                    <div class="text-4xl mb-4 text-emerald-500">🛍️</div>
                    <h4 class="font-semibold text-lg text-gray-800 mb-2">{{ __('Produits de qualité') }}</h4>
                    <p class="text-gray-600">{{ __('Nous sélectionnons les meilleurs produits pour vous.') }}</p>
                </div>
                <div>
                    <div class="text-4xl mb-4 text-pink-500">💬</div>
                    <h4 class="font-semibold text-lg text-gray-800 mb-2">{{ __('Support client 24/7') }}</h4>
                    <p class="text-gray-600">{{ __('Une équipe disponible pour vous accompagner.') }}</p>
                </div>
            </div>
        </div>

        <!-- Section Appel à l'action -->
        <div class="bg-black text-white rounded-2xl p-12 text-center">
            <h2 class="text-3xl font-bold mb-4">{{ __('Rejoignez la communauté') }}</h2>
            <p class="text-lg mb-6">{{ __('Créez votre compte et accédez à des offres exclusives.') }}</p>
            <a href="{{ route('register') }}" class="bg-white text-black font-semibold px-8 py-3 rounded-full hover:bg-gray-100 transition">
                {{ __('Créer un compte') }}
            </a>
        </div>

    </div>
</div>
@endsection
