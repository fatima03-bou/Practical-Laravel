@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-teal-400 to-cyan-500 px-4">
  <div class="bg-white p-12 rounded-3xl shadow-2xl w-full max-w-md">
    <h2 class="text-5xl font-bold text-center text-gray-800 mb-8">{{ __('Create Account') }}</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-8">
      @csrf

      {{-- Full Name --}}
      <div class="mb-6">
        <label for="name" class="block text-lg font-medium text-gray-700 mb-2">{{ __('Full Name') }}</label>
        <input id="name" type="text" name="name" required value="{{ old('name') }}"
          class="w-full px-6 py-4 text-lg border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300 @error('name') border-red-500 @enderror text-gray-800">
        @error('name')
        <p class="text-base text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Email --}}
      <div class="mb-6">
        <label for="email" class="block text-lg font-medium text-gray-700 mb-2">{{ __('Email Address') }}</label>
        <input id="email" type="email" name="email" required value="{{ old('email') }}"
          class="w-full px-6 py-4 text-lg border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300 @error('email') border-red-500 @enderror text-gray-800">
        @error('email')
        <p class="text-base text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Password --}}
      <div class="mb-6">
        <label for="password" class="block text-lg font-medium text-gray-700 mb-2">{{ __('Password') }}</label>
        <input id="password" type="password" name="password" required
          class="w-full px-6 py-4 text-lg border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300 @error('password') border-red-500 @enderror text-gray-800">
        @error('password')
        <p class="text-base text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Confirm Password --}}
      <div class="mb-10">
        <label for="password-confirm" class="block text-lg font-medium text-gray-700 mb-2">{{ __('Confirm Password') }}</label>
        <input id="password-confirm" type="password" name="password_confirmation" required
          class="w-full px-6 py-4 text-lg border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-300 text-gray-800">
      </div>

      {{-- Register Button --}}
      <div class="text-center">
        <button type="submit"
          class="w-full bg-teal-600 hover:bg-teal-700 text-white text-xl font-semibold py-3 rounded-lg transition duration-300 transform hover:scale-105">
          {{ __('Register') }}
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
