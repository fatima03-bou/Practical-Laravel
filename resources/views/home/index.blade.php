@extends('layouts.app')  <!-- Extend the main layout -->

@section('title', 'Home Page - Online Store')

@section('content')
    @if ($showImages)
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-2">
                <img src="{{ asset('/img/game.png') }}" class="img-fluid rounded">
            </div>
            <div class="col-md-6 col-lg-4 mb-2">
                <img src="{{ asset('/img/safe.png') }}" class="img-fluid rounded">
            </div>
            <div class="col-md-6 col-lg-4 mb-2">
                <img src="{{ asset('/img/submarine.png') }}" class="img-fluid rounded">
            </div>
        </div>
    @endif

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column text-center">
                        <h5 class="card-title fw-bold">{{ $product->getName() }}</h5>
                        <p class="mb-2">
                            <span class="badge bg-secondary">Prix : {{ number_format($product->getPrice(), 2) }} DH</span>
                        </p>
                        <p class="mb-1">
                            <small>Quantité en stock : <strong>{{ $product->getQuantityStore() }}</strong></small>
                        </p>
                        @if ($product->getQuantityStore() == 0)
                            <span class="badge bg-danger">Rupture de stock</span>
                        @endif
                        <div class="mt-auto">
                            <a href="{{ route('product.show', ['id' => $product->getId()]) }}" class="btn btn-outline-primary mt-3 w-100">
                                Voir le produit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
