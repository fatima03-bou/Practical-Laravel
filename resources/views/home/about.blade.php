@extends('layouts.app')

@section('title', __('About Us'))
@section('content')
<div class="bg-gradient-to-b from-blue-50 to-white py-20 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-gray-800 mb-4">{{ __('Your Trusted Online Destination') }}</h1>
            <p class="text-lg text-gray-600">{{ __('We bring together fashion, technology, and service to create something exceptional.') }}</p>
        </div>

        <!-- Who We Are -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-20">
            <div class="order-2 md:order-1">
                <h2 class="text-2xl font-semibold text-blue-600 mb-4">{{ __('Who We Are') }}</h2>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">
                    {{ __('We are a passionate team redefining online shopping in the modern era. Our mission is simple: combine style and accessibility, while offering a seamless user experience.') }}
                </p>
                <ul class="list-disc list-inside text-gray-700">
                    <li>{{ __('100% satisfaction guarantee') }}</li>
                    <li>{{ __('Curated collections updated weekly') }}</li>
                    <li>{{ __('Friendly and responsive support') }}</li>
                </ul>
            </div>
            <div class="order-1 md:order-2">
                <img src="{{ asset('storage/images/team.png') }}" alt="Team image" class="w-full rounded-xl shadow-lg">
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="bg-white rounded-3xl shadow-xl px-8 py-14 mb-20">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-10">{{ __('Why Choose Us?') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 text-center">
                <div>
                    <div class="text-5xl text-indigo-500 mb-4">🚚</div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ __('Fast Delivery') }}</h3>
                    <p class="text-gray-600">{{ __('We ship across the country in record time.') }}</p>
                </div>
                <div>
                    <div class="text-5xl text-pink-500 mb-4">🌟</div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ __('Top Rated Products') }}</h3>
                    <p class="text-gray-600">{{ __('All products are hand-picked by our team.') }}</p>
                </div>
                <div>
                    <div class="text-5xl text-green-500 mb-4">📞</div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ __('Customer First') }}</h3>
                    <p class="text-gray-600">{{ __('Our team is available 24/7 to help you.') }}</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ __('Join Our Story') }}</h2>
            <p class="text-gray-600 text-lg mb-6">{{ __('Create your account and enjoy exclusive benefits and promotions!') }}</p>
            <a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white font-semibold px-8 py-3 rounded-full hover:bg-blue-700 transition">
                {{ __('Sign Up Now') }}
            </a>
        </div>

    </div>
</div>
@endsection
