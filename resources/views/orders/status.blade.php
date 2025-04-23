@extends('layouts.app') {{-- ou layout de ton site --}}

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Suivi de votre commande</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>{{__('message.order_n')}}:</strong> {{ $order->id }}</p>
            <p><strong>{{__('message.statut')}}:</strong> {{ $order->status }}</p>
            <p><strong>{{__('message.total')}}:</strong> {{ $order->total }} MAD</p>
            <p><strong>{{__('message.prod')}}:</strong> {{ $order->product ? $order->product->name : 'Non spécifié' }}</p>
            <p><strong>{{__('message.update')}}:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('home.index') }}" class="btn btn-secondary mt-3">{{__('message.back_home')}}</a>
</div>
@endsection
