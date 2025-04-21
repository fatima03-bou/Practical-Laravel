@extends('layouts.app') {{-- ou layout de ton site --}}

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Suivi de votre commande</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Commande N°:</strong> {{ $order->id }}</p>
            <p><strong>Statut:</strong> {{ $order->status }}</p>
            <p><strong>Total:</strong> {{ $order->total }} MAD</p>
            <p><strong>Produit:</strong> {{ $order->product ? $order->product->name : 'Non spécifié' }}</p>
            <p><strong>Mis à jour le:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('home.index') }}" class="btn btn-secondary mt-3">Retour à l'accueil</a>
</div>
@endsection
