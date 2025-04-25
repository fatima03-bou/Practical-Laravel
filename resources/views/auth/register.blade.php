@extends('layouts.app')

@section('content')

<div class="flex items-center justify-center min-h-screen bg-gray-100 px-4">
  <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-xl">
    <h2 class="text-4xl font-bold text-center text-gray-800 mb-10">{{ __('create_account') }}</h2>


    <form method="POST" action="{{ route('register') }}" class="space-y-6">
      @csrf


      {{-- Full Name --}}
      <div class="mb-6">
        <label for="name" class="block text-lg font-medium text-gray-700 mb-2">{{ __('full_name') }}</label>
        <input id="name" type="text" name="name" required value="{{ old('name') }}"
          class="w-full px-6 py-4 text-lg border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
        @error('name')
        <p class="text-base text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Email --}}
      <div class="mb-6">
        <label for="email" class="block text-lg font-medium text-gray-700 mb-2">{{ __('email') }}</label>
        <input id="email" type="email" name="email" required value="{{ old('email') }}"
          class="w-full px-6 py-4 text-lg border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
        @error('email')
        <p class="text-base text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Password --}}
      <div class="mb-6">
        <label for="password" class="block text-lg font-medium text-gray-700 mb-2">{{ __('password') }}</label>
        <input id="password" type="password" name="password" required
          class="w-full px-6 py-4 text-lg border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
        @error('password')
        <p class="text-base text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Confirm Password --}}
      <div class="mb-10">
        <label for="password-confirm" class="block text-lg font-medium text-gray-700 mb-2">{{ __('confirm_password') }}</label>
        <input id="password-confirm" type="password" name="password_confirmation" required
          class="w-full px-6 py-4 text-lg border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

      </div>

      {{-- Register Button --}}
      <div class="text-center">
        <button type="submit"

          class="w-full bg-green-600 hover:bg-green-700 text-white text-xl font-semibold py-3 rounded-lg transition">
          {{ __('register') }}

        </button>
      </div>
    </form>
  </div>
</div>
@endsection
