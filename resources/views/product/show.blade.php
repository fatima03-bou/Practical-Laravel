@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $product->getName() }}
                    </h5>

                    {{-- Affichage du prix avec ou sans réduction --}}
                    <div class="mb-3">
                        @if($product->isDiscountActive())
                            <span class="text-muted text-decoration-line-through">
                                {{ $product->getPrice() }} DH
                            </span>
                            <span class="fw-bold text-danger fs-4">
                                {{ number_format($product->getDiscountedPrice(), 2) }} DH
                            </span>
                        @else
                            <span class="fw-bold fs-4">
                                {{ $product->getPrice() }} DH
                            </span>
                        @endif
                    </div>

                    <p class="card-text">
                        {{ $product->getDescription() }}
                    </p>

                    <p class="card-text">
                        Quantité en stock : {{ $product->getQuantityStore() }}
                    </p>

                    @if($product->getQuantityStore() > 0)
                        <form method="POST" action="{{ route('cart.add', ['product' => $product->id, 'quantity' => old('quantity', 1)]) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantité</label>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->getQuantityStore() }}" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">add cart</button>
                        </form>
                    @else
                        <div class="alert alert-warning mt-3">
                            En rupture de stock
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
