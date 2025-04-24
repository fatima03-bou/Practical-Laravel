@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="max-w-md mx-auto">
        <!-- Payment Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ __('messages.online_payment') ?? 'Online Payment' }}</h1>
            <p class="text-gray-600">{{ __('messages.secure_payment_process') ?? 'Complete your purchase with our secure payment process' }}</p>
        </div>
        
        <!-- Payment Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <!-- Card Header -->
            <div class="bg-primary-600 text-white py-4 px-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="font-semibold">{{ __('messages.secure_checkout') ?? 'Secure Checkout' }}</span>
                    </div>
                    <div class="flex space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Payment Form -->
            <form action="{{ route('cart.purchase') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Personal Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 pb-2 border-b">{{ __('messages.personal_information') ?? 'Personal Information' }}</h3>
                    
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('messages.full_name') ?? 'Full Name' }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="full_name" id="full_name"
                            class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('messages.email') ?? 'Email' }} <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email"
                            class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 pb-2 border-b">{{ __('messages.payment_information') ?? 'Payment Information' }}</h3>
                    
                    <!-- Card Number -->
                    <div>
                        <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('messages.card_number') ?? 'Card Number' }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="card_number" id="card_number"
                                class="w-full pl-11 pr-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition"
                                placeholder="1234 5678 9012 3456" required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <div class="flex space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#1434CB">
                                        <path d="M11.343 18.031c.058.049.12.098.181.146-1.177.783-2.59 1.242-4.107 1.242-4.114 0-7.455-3.342-7.455-7.456 0-4.113 3.341-7.455 7.455-7.455 1.517 0 2.93.459 4.107 1.242-.061.048-.123.098-.181.146-1.177.783-1.959 2.184-1.959 3.771v4.592c0 1.587.782 2.988 1.959 3.772zm11.304-7.456c0 4.114-3.341 7.456-7.455 7.456-1.517 0-2.93-.459-4.107-1.242.058-.048.12-.097.181-.146 1.177-.784 1.959-2.185 1.959-3.772v-4.592c0-1.587-.782-2.988-1.959-3.771-.061-.048-.123-.098-.181-.146 1.177-.783 2.59-1.242 4.107-1.242 4.114 0 7.455 3.342 7.455 7.455z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#FF5F00">
                                        <path d="M15.245 17.831c-1.177.784-2.59 1.242-4.107 1.242-4.114 0-7.455-3.342-7.455-7.456 0-4.113 3.341-7.455 7.455-7.455 1.517 0 2.93.459 4.107 1.242 1.177.783 1.959 2.184 1.959 3.771v4.592c0 1.587-.782 2.988-1.959 3.772z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Expiry and CVV -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('messages.expiry_date') ?? 'Expiry Date' }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="expiry_date" id="expiry_date"
                                class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition"
                                placeholder="MM / YY" required>
                        </div>
                        <div>
                            <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('messages.cvv') ?? 'CVV' }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="cvv" id="cvv"
                                    class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition"
                                    placeholder="123" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="method" value="online">

                <!-- Order Summary -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ __('messages.order_summary') ?? 'Order Summary' }}</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ __('messages.subtotal') ?? 'Subtotal' }}</span>
                            <span class="font-medium">$99.99</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ __('messages.shipping') ?? 'Shipping' }}</span>
                            <span class="font-medium">$4.99</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ __('messages.tax') ?? 'Tax' }}</span>
                            <span class="font-medium">$10.00</span>
                        </div>
                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between font-semibold">
                                <span class="text-gray-800">{{ __('messages.total') ?? 'Total' }}</span>
                                <span class="text-primary-600">$114.98</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pay Button -->
                <div>
                    <button type="submit"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-lg transition flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        {{ __('messages.pay_now') ?? 'Pay Now' }}
                    </button>
                </div>

                <!-- Alternative Payment Methods -->
                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-3">{{ __('messages.or_pay_using') ?? 'Or pay using' }}</p>
                    <div class="flex justify-center space-x-3">
                        <button type="button" class="bg-[#0070BA] hover:bg-[#005ea6] text-white font-medium py-2 px-4 rounded-lg transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white" class="mr-2">
                                <path d="M7.076 21.337h-2.843c-.834 0-1.51-.676-1.51-1.51v-12.314c0-.834.676-1.51 1.51-1.51h2.843c.834 0 1.51.676 1.51 1.51v12.314c0 .834-.676 1.51-1.51 1.51zm12.351-14.244c-.006-1.109-.695-2.095-1.747-2.513-.406-.161-.872-.269-1.354-.269h-2.283c-.884 0-1.693.392-2.235 1.013-.542-.621-1.351-1.013-2.235-1.013h-2.283c-.482 0-.948.108-1.354.269-1.052.418-1.741 1.404-1.747 2.513v12.074c0 1.512 1.227 2.74 2.74 2.74h2.687c.700 0 1.332-.289 1.785-.756.452.466 1.084.756 1.785.756h2.687c1.512 0 2.74-1.228 2.74-2.74v-12.074zm-8.337 12.728h-2.039c-.458 0-.829-.371-.829-.829v-10.812c0-.458.371-.829.829-.829h2.039c.458 0 .829.371.829.829v10.812c0 .458-.371.829-.829.829zm6.292 0h-2.039c-.458 0-.829-.371-.829-.829v-10.812c0-.458.371-.829.829-.829h2.039c.458 0 .829.371.829.829v10.812c0 .458-.371.829-.829.829z"/>
                            </svg>
                            PayPal
                        </button>
                        <button type="button" class="bg-black hover:bg-gray-800 text-white font-medium py-2 px-4 rounded-lg transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white" class="mr-2">
                                <path d="M22 9.24l-7.19-.62L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.63-7.03L22 9.24zM12 15.4l-3.76 2.27 1-4.28-3.32-2.88 4.38-.38L12 6.1l1.71 4.04 4.38.38-3.32 2.88 1 4.28L12 15.4z"/>
                            </svg>
                            Apple Pay
                        </button>
                    </div>
                </div>
            </form>
            
            <!-- Security Notice -->
            <div class="bg-gray-50 px-6 py-4 text-center border-t">
                <div class="flex items-center justify-center text-sm text-gray-600 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    {{ __('messages.secure_transaction') ?? 'Secure Transaction' }}
                </div>
                <div class="flex justify-center space-x-4">
                    <img src="https://cdn.pixabay.com/photo/2015/05/26/09/37/paypal-784404_1280.png" alt="PayPal" class="h-6">
                    <img src="https://cdn.pixabay.com/photo/2021/12/06/13/48/visa-6850402_1280.png" alt="Visa" class="h-6">
                    <img src="https://cdn.pixabay.com/photo/2015/05/26/09/37/mastercard-784405_1280.png" alt="MasterCard" class="h-6">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
