@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="mb-4">
  <form method="GET" action="{{ route('product.index') }}">
    <div class="row g-3 align-items-end">
      <div class="col-md-6">
        <label for="categorie_id" class="form-label fw-bold">Filtrer par catégorie :</label>
        <select name="categorie_id" class="form-select" onchange="this.form.submit()">
          <option value="">Toutes les catégories</option>
          @foreach ($viewData['categories'] as $categorie)
            <option value="{{ $categorie->id }}" 
              @if(request('categorie_id') == $categorie->id) selected @endif>
              {{ $categorie->name }}
            </option>
          @endforeach
        </select>
      </div>
    </div>
  </form>
</div>

<div class="row">
  @foreach ($viewData["products"] as $product)
    <div class="col-md-4 col-lg-3 mb-4">
      <div class="card h-100 shadow-sm border-0">
        <img src="{{('storage/images/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
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
            <a href="{{ route('product.show', ['id'=> $product->getId()]) }}" class="btn btn-outline-primary mt-3 w-100">
              Voir le produit
            </a>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
