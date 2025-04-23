@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])
@section('content')
<div class="card">
  <div class="card-header">
    {{__('message.product_in_cart')}}
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">{{__('message.name')}}</th>
          <th scope="col">{{__('message.price')}}</th>
          <th scope="col">{{__('message.quantity')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($viewData["products"] as $product)
        <tr>
          <td>{{ $product->getId() }}</td>
          <td>{{ $product->getName() }}</td>
          <td>${{ $product->getPrice() }}</td>
          <td>{{ session('products')[$product->getId()] }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="row">
      <div class="text-end">
        <a class="btn btn-outline-secondary mb-2"><b>{{__('message.total_pay')}}:</b> ${{ $viewData["total"] }}</a>
        @if (count($viewData["products"]) > 0)
        <a href="{{ route('cart.purchase') }}" class="btn bg-primary text-white mb-2">{{__('message.purchase')}}</a>
        <a href="{{ route('cart.delete') }}">
          <button class="btn btn-danger mb-2">
            {{__('message.remove_all_prod')}}
          </button>
        </a>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
