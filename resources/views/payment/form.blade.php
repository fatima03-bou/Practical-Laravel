<!-- resources/views/payment/form.blade.php -->

@extends('layouts.app')

@section('title', 'Payment')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Payment Information</h5>
                </div>
                <div class="card-body">
                    <form id="payment-form" action="{{ route('payment.process') }}" method="POST">
                        @csrf

                        <!-- Full Name -->
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control" required placeholder="John Doe">
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" required placeholder="john@example.com">
                        </div>

                        <!-- Address -->
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address" name="address" class="form-control" required placeholder="123 Street Name">
                        </div>

                        <div class="form-row d-flex gap-3">
                            <div class="form-group flex-fill">
                                <label for="city" class="form-label">City</label>
                                <input type="text" id="city" name="city" class="form-control" required>
                            </div>
                            <div class="form-group flex-fill">
                                <label for="zip" class="form-label">ZIP Code</label>
                                <input type="text" id="zip" name="zip" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="country" class="form-label">Country</label>
                            <select id="country" name="country" class="form-select" required>
                                <option value="">Choose a country</option>
                                <option value="US">United States</option>
                                <option value="FR">France</option>
                                <option value="MA">Morocco</option>
                            </select>
                        </div>

                        <!-- Payment Method -->
                        <div class="form-group mt-4">
                            <label class="form-label">Payment Method</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="online" value="online" checked>
                                <label class="form-check-label" for="online">
                                    Pay Online (Credit or Debit Card)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod">
                                <label class="form-check-label" for="cod">
                                    Pay on Delivery (Cash)
                                </label>
                            </div>
                        </div>

                        <!-- Custom Card Input (shown only for Pay Online) -->
                        <div class="form-group mt-4" id="card-input-section">
                            <label for="card_number" class="form-label">Credit or Debit Card Number</label>
                            <input type="text" id="card_number" name="card_number" class="form-control" placeholder="XXXX-XXXX-XXXX-XXXX">
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" id="submit-button" class="btn btn-success">
                                <span id="button-text">Confirm Payment</span>
                                <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cardSection = document.getElementById('card-input-section');
        const radioOnline = document.getElementById('online');
        const radioCod = document.getElementById('cod');

        // Function to toggle the visibility of the card input section
        function toggleCardSection() {
            if (radioCod.checked) {
                cardSection.classList.add('d-none'); // Hide card section if "Pay on Delivery" is selected
            } else {
                cardSection.classList.remove('d-none'); // Show card section if "Pay Online" is selected
            }
        }

        // Event listeners for radio button changes
        radioOnline.addEventListener('change', toggleCardSection);
        radioCod.addEventListener('change', toggleCardSection);

        // Initialize visibility based on the default checked radio button
        toggleCardSection();

        // Handle form submission state
        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const buttonText = document.getElementById('button-text');
        const spinner = document.getElementById('spinner');

        form.addEventListener('submit', function () {
            buttonText.classList.add('d-none');
            spinner.classList.remove('d-none');
            submitButton.disabled = true;
        });
    });
</script>
@endsection
