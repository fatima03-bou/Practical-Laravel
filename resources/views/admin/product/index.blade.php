@extends('layouts.admin')
@section('title', $viewData['title'])

@section('content')

<div class="card mb-4">
  <div class="card-header">
    Create Products
  </div>
  <div class="card-body">
    @if($errors->any())
      <ul class="alert alert-danger list-unstyled">
        @foreach($errors->all() as $error)
          <li>- {{ $error }}</li>
        @endforeach
      </ul>
    @endif

    <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Name:</label>
          <input name="name" value="{{ old('name') }}" type="text" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Price (€):</label>
          <input name="price" value="{{ old('price') }}" type="number" step="0.01" class="form-control" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Quantity Store:</label>
          <input name="quantity_store" value="{{ old('quantity_store') }}" type="number" min="1" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Image:</label>
          <input class="form-control" type="file" name="image">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Fournisseur</label>
          <select name="fournisseur_id" class="form-control">
            <option value="">Sélectionner un fournisseur</option>
            @foreach($viewData['fournisseurs'] as $fournisseur)
              <option value="{{ $fournisseur->id }}">{{ $fournisseur->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Catégorie</label>
          <select name="categorie_id" class="form-control">
            <option value="">Sélectionner une catégorie</option>
            @foreach($viewData['categories'] as $categorie)
              <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
  </div>
</div>

<!-- Table de gestion des produits -->
<div class="card">
  <div class="card-header">
    Manage Products
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Price (€)</th>
            <th scope="col">Quantity Store</th>
            <th scope="col">Categorie</th>
            <th scope="col">Fournisseur</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($viewData["products"] as $product)
          <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>
              @if($product->discounted_price)
                <span class="text-danger fw-bold">{{ number_format($product->discounted_price, 2) }} €</span><br>
                <small class="text-muted text-decoration-line-through">{{ number_format($product->price, 2) }} €</small>
              @else
                {{ number_format($product->price, 2) }} €
              @endif
            </td>
                        <td>{{ $product->quantity_store }}</td>
            <td>{{ optional($product->categorie)->name }}</td>
            <td>{{ optional($product->fournisseur)->name }}</td>
            <td>
              <a class="btn btn-primary btn-sm" href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                <i class="bi-pencil"></i>
              </a>
            </td>
            <td>
              <form action="{{ route('admin.product.delete', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">
                  <i class="bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
