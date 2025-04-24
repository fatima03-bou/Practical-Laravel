@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="bg-white min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-6">
        
        <!-- Title -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-semibold text-gray-800">{{ $viewData["title"] }}</h1>
            <p class="text-gray-600 text-lg">{{ $viewData["subtitle"] }}</p>
        </div>

        <!-- About the Project -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center mb-16">
            <div>
                <h2 class="text-2xl font-semibold text-blue-700 mb-4">{{ __('messages.who_are_we') }}</h2>
                <p class="text-gray-700 text-lg leading-relaxed">
                    {{ $viewData["description"] }}
                </p>
            </div>
            <div>
                <img src="https://cdn.prod.website-files.com/62196607bf1b46c300301846/6568ada0ea9d4603d85a24df_ojszptselv3sfysmejml.webp" alt="About us" class="w-full h-auto rounded-xl shadow-lg">
            </div>
        </div>

        <!-- Developer / Team Information -->
        <div class="bg-gray-100 rounded-xl p-10 shadow-md mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('messages.developer_team') }}</h2>
            <p class="text-gray-700 text-lg">
                {{ $viewData["author"] }}
            </p>
        </div>

        <!-- Project Features -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">{{ __('messages.unique_project') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6 bg-white rounded-lg shadow hover:shadow-md transition">
                    <div class="text-4xl mb-3 text-blue-500">⚡</div>
                    <h3 class="font-semibold text-xl mb-2">{{ __('messages.fast_interface') }}</h3>
                    <p class="text-gray-600">{{ __('messages.fast_interface_description') }}</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow hover:shadow-md transition">
                    <div class="text-4xl mb-3 text-green-500">🔒</div>
                    <h3 class="font-semibold text-xl mb-2">{{ __('messages.security_privacy') }}</h3>
                    <p class="text-gray-600">{{ __('messages.security_privacy_description') }}</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow hover:shadow-md transition">
                    <div class="text-4xl mb-3 text-purple-500">🌍</div>
                    <h3 class="font-semibold text-xl mb-2">{{ __('messages.comprehensive_support') }}</h3>
                    <p class="text-gray-600">{{ __('messages.comprehensive_support_description') }}</p>
                </div>
            </div>
        </div>

        <!-- Call to Contact -->
        <div class="text-center mt-16">
            <h2 class="text-2xl font-semibold text-gray-800 mb-3">{{ __('messages.contact_us') }}</h2>
            <p class="text-gray-600 mb-4">{{ __('messages.contact_us_description') }}</p>
        </div>
    </div>
</div>
@endsection
