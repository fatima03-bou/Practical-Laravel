@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])
@section('content')
@forelse ($viewData["orders"] as $order)
<div class="card mb-4">
  <div class="card-header">
    {{__('message.order')}} #{{ $order->getId() }}
  </div>
  <div class="card-body">
    <b>{{__('message.date')}}:</b> {{ $order->getCreatedAt() }}<br />
    <b>{{__('message.total')}}:</b> ${{ $order->getTotal() }}<br />
    <table class="table table-bordered table-striped text-center mt-3">
      <thead>
        <tr>
          <th scope="col"> ID</th>
          <th scope="col">{{__('message.prod')}}</th>
          <th scope="col">{{__('message.price')}}</th>
          <th scope="col">{{__('message.quantity')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($order->getItems() as $item)
        <tr>
          <td>{{ $item->getId() }}</td>
          <td>
            <a class="link-success" href="{{ route('product.show', ['id'=> $item->getProduct()->getId()]) }}">
              {{ $item->getProduct()->getName() }}
            </a>
          </td>
          <td>${{ $item->getPrice() }}</td>
          <td>{{ $item->getQuantity() }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@empty
<div class="alert alert-danger" role="alert">
    {{__('message.order_alert')}}
</div>
@endforelse
@endsection
