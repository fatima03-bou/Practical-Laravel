@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="card">
  <div class="card-header">
    Products in Cart
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Price</th>
          <th scope="col">Quantity</th>
          <th scope="col">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @php
          $cart = json_decode(request()->cookie('cart'), true) ?? [];
        @endphp
        @foreach ($viewData["products"] as $product)
        <tr>
          <td>{{ $product->getId() }}</td>
          <td>{{ $product->getName() }}</td>
          <td>
            @if ($product->hasDiscount())
              <span class="text-danger fw-bold">${{ $product->getDiscountedPrice() }}</span>
              <br>
              <small><s>${{ $product->getPrice() }}</s></small>
            @else
              ${{ $product->getPrice() }}
            @endif
          </td>
          <td>{{ $cart[$product->getId()] ?? 0 }}</td>
          <td>
            @php
              $price = $product->hasDiscount() ? $product->getDiscountedPrice() : $product->getPrice();
              $quantity = $cart[$product->getId()] ?? 0;
            @endphp
            ${{ $price * $quantity }}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="row">
      <div class="text-end">
        <a class="btn btn-outline-secondary mb-2"><b>Total to pay:</b> ${{ $viewData["total"] }}</a>
        @if (count($viewData["products"]) > 0)
        <a href="{{ route('cart.purchase') }}" class="btn bg-primary text-white mb-2">Purchase</a>
        <a href="{{ route('cart.delete') }}">
          <button class="btn btn-danger mb-2">
            Remove all products from Cart
          </button>
        </a>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
