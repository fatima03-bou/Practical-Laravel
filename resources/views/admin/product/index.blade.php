@extends('layouts.admin')

@section('title', $viewData['title'])

@section('content')

<div class="card mb-4">
  <div class="card-header">
    Create Products
  </div>
  <div class="card-body">
    @if ($errors->any())
      <ul class="alert alert-danger list-unstyled">
        @foreach ($errors->all() as $error)
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
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Price:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="price" value="{{ old('price') }}" type="number" min="1"   step="0.01" class="form-control">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Discount Price:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="discount_price" value="{{ old('discount_price') }}" type="number" min="1" step="0.01" class="form-control">
            </div>
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Image:</label>
          <input class="form-control" type="file" name="image">
        </div>
      </div>
      <div class="col">
        <div class="mb-3 row">
          <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Quantité:</label>
          <div class="col-lg-10 col-md-6 col-sm-12">
            <input name="quantity_store" value="{{ old('quantity_store') }}" type="number" min="1" class="form-control">
          </div>
        </div>
      </div>
      

      <div class="mb-3 row">
        <label class="col-lg-2 col-form-label">Fournisseur:</label>
        <div class="col-lg-10">
          <select name="fournisseur_id" class="form-control">
            <option value="">-- Sélectionner un fournisseur --</option>
            @foreach($viewData["fournisseurs"] as $fournisseur)
              <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                {{ $fournisseur->raison }}
              </option>
            @endforeach
          </select>
        </div>
      </div>


      <div class="mb-3 row">
        <label class="col-lg-2 col-form-label">Catégorie:</label>
        <div class="col-lg-10">
          <select name="categorie_id" class="form-control">
            <option value="">-- Sélectionner une catégorie --</option>
            @foreach($viewData["categories"] as $categorie)
              <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                {{ $categorie->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-form-label">Stock Quantity:</label>
            <div class="col-lg-10">
              <input name="quantity_store" value="{{ old('quantity_store') }}" type="number" class="form-control">
            </div>
          </div>
        </div>
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-form-label">Supplier:</label>
            <div class="col-lg-10">
              <select name="fournisseur_id" class="form-control">
                <option value="">Select Supplier</option>
                @foreach($viewData["fournisseurs"] as $fournisseur)
                  <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                    {{ $fournisseur->raison }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<!-- Section de filtres -->
<div class="filter-section card mb-4">
  <div class="card-header">Filtres</div>
  <div class="card-body">
    <form action="{{ route('admin.products.index') }}" method="GET">
      <div class="form-group mb-3">
        <label for="category_id">Catégorie</label>
        <select name="category_id" id="category_id" class="form-control">
          <option value="">Toutes les catégories</option>
          @foreach($viewData["categories"] as $category)
            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div>


      <div class="form-group mb-3">
        <label for="fournisseur_id">Fournisseur</label>
        <select name="fournisseur_id" id="fournisseur_id" class="form-control">
          <option value="">Tous les fournisseurs</option>
          @foreach($viewData["fournisseurs"] as $fournisseur)
            <option value="{{ $fournisseur->id }}" {{ request('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
              {{ $fournisseur->raison }}
            </option>
          @endforeach
        </select>
      </div>
      
      <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="on_sale" name="on_sale" value="1" {{ request('on_sale') ? 'checked' : '' }}>
        <label class="form-check-label" for="on_sale">Produits en solde uniquement</label>
      </div>

      <button type="submit" class="btn btn-primary">Filtrer</button>
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
            <td>{{ number_format($product->price, 2) }} €</td>
            <td>{{ $product->quantity_store }}</td>
            <td>{{ optional($product->categorie)->name }}</td>
            <td>{{ optional($product->fournisseur)->raison }}</td>
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
