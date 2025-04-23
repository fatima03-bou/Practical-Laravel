@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])
@section('content')
<div class="card">
  <div class="card-header">
    {{__('message.purchase_compl')}}
  </div>
  <div class="card-body">
    <div class="alert alert-success" role="alert">
      Congratulations, purchase completed. Order number is <b>#{{ $viewData["order"]->getId() }}</b>
    </div>
    <a href="{{ route('order.status', ['id' => $viewData['order']->getId()]) }}" class="btn btn-outline-primary">
        {{__('message.show_status')}}
    </a>
  </div>
</div>
@endsection
