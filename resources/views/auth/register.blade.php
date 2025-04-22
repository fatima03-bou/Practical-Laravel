@extends('layouts.app')
<div class="container d-flex justify-content-center align-items-center min-vh-100 py-5" style="background: linear-gradient(135deg, #6e7bff, #a8caff);">
    <div class="row w-100">
        <div class="col-md-6 col-lg-4 mx-auto">
            <div class="card shadow-lg rounded-5 border-0 p-4" style="width: 350px; animation: fadeIn 1s ease-in-out;">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="text-primary fw-bold" style="font-family: 'Roboto Slab', serif;">Create Your Account</h2>
                        <p class="text-muted">Please register to continue</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="form-label text-dark" style="font-size: 1.1rem;">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus style="border-radius: 12px; padding: 18px; border: 2px solid #ddd;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label text-dark" style="font-size: 1.1rem;">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" style="border-radius: 12px; padding: 18px; border: 2px solid #ddd;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label text-dark" style="font-size: 1.1rem;">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="border-radius: 12px; padding: 18px; border: 2px solid #ddd;">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label text-dark" style="font-size: 1.1rem;">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" style="border-radius: 12px; padding: 18px; border: 2px solid #ddd;">
                        </div>

                        <!-- Register Button -->
                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #6e7bff, #3e5ad7); color: white; border-radius: 12px; padding: 15px 25px; font-size: 16px; transition: transform 0.2s ease, background 0.3s ease;">
                                {{ __('Register') }}
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center mt-3">
                            <small class="text-muted">Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animation for fading in the card */
    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card styling */
    .card {
        background-color: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    /* Form Field focus effect */
    .form-control:focus {
        border-color: #6e7bff;
        box-shadow: 0 0 8px rgba(110, 123, 255, 0.5);
    }

    /* Button hover effect */
    .btn:hover {
        background: linear-gradient(135deg, #3e5ad7, #6e7bff);
        transform: scale(1.05);
    }

    /* Link hover effect */
    .text-primary:hover {
        text-decoration: underline;
    }
</style>
