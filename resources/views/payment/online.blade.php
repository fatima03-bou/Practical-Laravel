@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="max-w-md mx-auto">
        <!-- Payment Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ __('online_payment') ?? 'Complete Your Payment' }}</h1>
            <p class="text-gray-600 text-lg">{{ __('secure_payment_process') ?? 'Your payment is safe with our secure checkout.' }}</p>
        </div>
        
        <!-- Payment Card -->
        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-teal-400 via-cyan-500 to-blue-500 text-white py-8 px-8 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="font-semibold text-xl">{{ __('secure_checkout') ?? 'Secure Checkout' }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Payment Form -->
            <form action="{{ route('cart.purchase') }}" method="POST" class="space-y-8 px-8 py-6 bg-gray-50">
                @csrf

                <!-- Personal Information -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800">{{ __('personal_information') ?? 'Personal Information' }}</h3>
                    
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700">{{ __('full_name') ?? 'Full Name' }} <span class="text-red-500">*</span></label>
                        <input type="text" name="full_name" id="full_name"
                            class="w-full px-6 py-4 text-gray-800 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="John Doe" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('email') ?? 'Email' }} <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email"
                            class="w-full px-6 py-4 text-gray-800 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="johndoe@example.com" required>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800">{{ __('payment_information') ?? 'Payment Information' }}</h3>
                    
                    <!-- Card Number -->
                    <div>
                        <label for="card_number" class="block text-sm font-medium text-gray-700">{{ __('card_number') ?? 'Card Number' }} <span class="text-red-500">*</span></label>
                        <input type="text" name="card_number" id="card_number"
                            class="w-full pl-12 pr-4 py-4 text-gray-800 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="1234 5678 9012 3456" required>
                    </div>

                    <!-- Expiry and CVV -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700">{{ __('expiry_date') ?? 'Expiry Date' }} <span class="text-red-500">*</span></label>
                            <input type="text" name="expiry_date" id="expiry_date"
                                class="w-full px-6 py-4 text-gray-800 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition"
                                placeholder="MM / YY" required>
                        </div>
                        <div>
                            <label for="cvv" class="block text-sm font-medium text-gray-700">{{ __('cvv') ?? 'CVV' }} <span class="text-red-500">*</span></label>
                            <input type="text" name="cvv" id="cvv"
                                class="w-full px-6 py-4 text-gray-800 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition"
                                placeholder="123" required>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('order_summary') ?? 'Order Summary' }}</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ __('subtotal') ?? 'Subtotal' }}</span>
                            <span class="font-medium text-gray-800">$99.99</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ __('shipping') ?? 'Shipping' }}</span>
                            <span class="font-medium text-gray-800">$4.99</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ __('tax') ?? 'Tax' }}</span>
                            <span class="font-medium text-gray-800">$10.00</span>
                        </div>
                        <div class="border-t pt-4 mt-4">
                            <div class="flex justify-between font-semibold">
                                <span class="text-gray-800">{{ __('total') ?? 'Total' }}</span>
                                <span class="text-primary-500">$114.98</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pay Button -->
                <div>
                    <button type="submit"
                        class="w-full bg-primary-500 hover:bg-primary-600 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 ease-in-out">
                        {{ __('pay_now') ?? 'Pay Now' }}
                    </button>
                </div>

                <!-- Alternative Payment Methods -->
               
            </form>

            <!-- Security Notice -->
            <div class="bg-gray-50 px-6 py-4 text-center border-t">
                <div class="flex items-center justify-center text-sm text-gray-600 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    {{ __('secure_transaction') ?? 'Secure Transaction' }}
                </div>
                <div class="flex justify-center space-x-6">
                    <img src="https://cdn.pixabay.com/photo/2015/05/26/09/37/paypal-784404_1280.png" alt="PayPal" class="h-6">
                    <img src="https://cdn.pixabay.com/photo/2021/12/06/13/48/visa-6850402_1280.png" alt="Visa" class="h-6">
                    <img src="https://cdn.pixabay.com/photo/2015/05/26/09/37/apple-pay-784405_1280.png" alt="Apple Pay" class="h-6">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
