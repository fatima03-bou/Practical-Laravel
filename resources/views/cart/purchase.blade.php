@extends('layouts.app')

@section('title', $viewData["title"])

@section('subtitle', $viewData["subtitle"])

@section('content')

<div class="card">

  <div class="card-header">

    Purchase Completed

  </div>

  <div class="card-body">

    <div class="alert alert-success" role="alert">

      Congratulations, purchase completed. Order number is <b>#{{ $viewData["order"]->id }}</b> <!-- Direct access to id -->

    </div>

    <a href="{{ route('order.status', ['id' => $viewData['order']->id]) }}" class="btn btn-outline-primary"> <!-- Direct access to id -->

      Voir le statut de la commande

    </a>

  </div>

</div>

@endsection
