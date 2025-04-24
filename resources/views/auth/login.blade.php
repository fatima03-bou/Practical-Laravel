@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100 px-4">
  <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-xl">
    <h2 class="text-4xl font-bold text-center text-gray-800 mb-10">Login</h2>

    <form method="POST" action="{{ route('login') }}">
      @csrf

      {{-- Email --}}
      <div class="mb-6">
        <label for="email" class="block text-lg font-medium text-gray-700 mb-2">Email Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
          class="w-full px-6 py-4 text-lg border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
        @error('email')
        <p class="text-base text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Password --}}
      <div class="mb-6">
        <label for="password" class="block text-lg font-medium text-gray-700 mb-2">Password</label>
        <input id="password" type="password" name="password" required
          class="w-full px-6 py-4 text-lg border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
        @error('password')
        <p class="text-base text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Remember Me --}}
      <div class="mb-6 flex items-center">
        <input type="checkbox" name="remember" id="remember" class="mr-3 h-5 w-5"
          {{ old('remember') ? 'checked' : '' }}>
        <label for="remember" class="text-lg text-gray-700">Remember Me</label>
      </div>

      {{-- Submit & Forgot --}}
      <div class="flex flex-col gap-4">
        <button type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xl font-semibold py-3 rounded-lg transition">
          Login
        </button>

        @if (Route::has('password.request'))
        <a class="text-center text-base text-blue-600 hover:underline" href="{{ route('password.request') }}">
          Forgot Your Password?
        </a>
        @endif
      </div>
    </form>
  </div>
</div>
@endsection
