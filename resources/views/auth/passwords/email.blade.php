@extends('layouts.app')

@section('content')
      {{-- Email --}}
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
          class="w-full px-4 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
        @error('email')
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Submit Button --}}
      <div>
        <button type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md transition">
          Send Password Reset Link
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
