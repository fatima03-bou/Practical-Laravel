@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="mb-3">
  <form method="GET" action="{{ route('product.index') }}">
    <div class="row">
      <!-- Filter by Category -->
      <div class="col-md-6">
        <label for="category_id" class="form-label">Filter by Category:</label>
        <select name="category_id" class="form-select" onchange="this.form.submit()">
          <option value="">All Categories</option>
          @foreach ($viewData['categories'] as $category)
            <option value="{{ $category->id }}" 
              @if(request('category_id') == $category->id) selected @endif>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Filter by Supplier -->
      <div class="col-md-6">
        <label for="fournisseur_id" class="form-label">Filter by Supplier:</label>
        <select name="fournisseur_id" class="form-select" onchange="this.form.submit()">
          <option value="">All Suppliers</option>
          @foreach ($viewData['fournisseurs'] as $fournisseur)
            <option value="{{ $fournisseur->id }}" 
              @if(request('fournisseur_id') == $fournisseur->id) selected @endif>
              {{ $fournisseur->raison}}
            </option>
          @endforeach
        </select>
      </div>
    </div>
  </form>
</div>

<div class="row">
  @foreach ($viewData["products"] as $product)
    <div class="col-md-4 col-lg-3 mb-2">
      <div class="card">
        <img src="{{ Storage::url('images/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top">
        <div class="card-body text-center">
          <a href="{{ route('product.show', ['id'=> $product->getId()]) }}" class="btn bg-primary text-white">
            {{ $product->getName() }}
          </a>
          <p>
            <span>Quantity in stock: {{ $product->getQuantityStore() }}</span>
          </p>
          @if ($product->getQuantityStore() == 0)
            <p class="badge bg-danger">Out of stock</p>
          @endif
        </div>
      </div>
    </div>
  @endforeach
</div>
<div class="d-flex justify-content-center mt-4">
        {{ $viewData["products"]->links() }}
    </div>
@endsection