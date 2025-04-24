<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .order-items img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .container {
            max-width: 800px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thank You for Your Payment!</h2>
        <p>Your payment has been successfully processed.</p>

        <h3>Order Details</h3>
        <ul>
            <li><strong>Total Amount:</strong> €{{ $order->total }}</li>
            <li><strong>Status:</strong> {{ $order->status }}</li>
            <li><strong>Expected Delivery Date:</strong> {{ $deliveryDate->format('l, F j, Y') }}</li>
        </ul>

        <h3>Payment Details</h3>
        <ul>
            <li><strong>Full Name:</strong> {{ $paymentDetails['name'] }}</li>
            <li><strong>Email Address:</strong> {{ $paymentDetails['email'] }}</li>
            <li><strong>Address:</strong> {{ $paymentDetails['address'] }}</li>
            <li><strong>City:</strong> {{ $paymentDetails['city'] }}</li>
        </ul>

        <a href="{{ url('/') }}" class="btn btn-primary mt-4">Go to Home</a>
    </div>
</body>
</html>
