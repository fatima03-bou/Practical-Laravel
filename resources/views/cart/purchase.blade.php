@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])


@section('content')
<div class="container mx-auto mt-8">
  <div class="bg-white shadow-lg rounded-lg p-8">
    <!-- Header Section -->
    <div class="border-b pb-4 mb-6">
      <h3 class="text-2xl font-bold text-gray-800">🎉 {{ __('messages.purchase_completed') }}</h3>
    </div>

    <!-- Success Message -->
    <div class="bg-green-50 border border-green-400 text-green-700 px-6 py-4 rounded-lg flex items-center gap-4" role="alert">
      <div class="text-3xl">
        ✅
      </div>
      <div>
        <p class="text-lg font-medium">
          {{ __('messages.congratulations') }} 
        
        </p>
        <p class="mt-2">
          {{ __('messages.thank_you_for_your_order') }} <br>
          {{ __('messages.your_order_is_being_processed') }} <br>
          {{ __('messages.your_order_number') }}: <b class="text-green-800">#{{ $viewData["order"]->getId() }}</b>.
         
        </p>
      </div>
    </div>

    <!-- Next Steps Section -->
    <div class="mt-8">
      <h4 class="text-lg font-semibold text-gray-800 mb-4">What’s Next?</h4>
      <ul class="list-disc list-inside text-gray-700 space-y-2">
        <li>Track your order in the <a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline">Orders Page</a>.</li>
        <li>Continue shopping for more amazing products <a href="{{ route('product.index') }}" class="text-blue-600 hover:underline">here</a>.</li>
        <li>If you have any questions, feel free to <a href="{{ route('home.about') }}" class="text-blue-600 hover:underline">contact us</a>.</li>
      </ul>
    </div>
  </div>
</div>
@endsection
