@extends('layouts.admin')

@section('title', $viewData["title"])

@section('content')

<!-- Product Creation Form -->
<div class="card mb-4 shadow-sm">
  <div class="card-header bg-primary text-white fw-bold">
    Create Product
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>- {{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Product Name</label>
          <input name="name" value="{{ old('name') }}" type="text" class="form-control" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Price (€)</label>
          <input name="price" value="{{ old('price') }}" type="number" min="1" step="0.01" class="form-control" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Discount Price (€)</label>
          <input name="discount_price" value="{{ old('discount_price') }}" type="number" min="1" step="0.01" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Stock Quantity</label>
          <input name="quantity_store" value="{{ old('quantity_store') }}" type="number" min="1" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Image</label>
          <input class="form-control" type="file" name="image">
        </div>
        <div class="col-md-6">
          <label class="form-label">Supplier</label>
          <select name="fournisseur_id" class="form-select">
            <option value="">-- Select a supplier --</option>
            @foreach($viewData["fournisseurs"] as $fournisseur)
              <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                {{ $fournisseur->raison_social }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Category</label>
          <select name="categorie_id" class="form-select">
            <option value="">-- Select a category --</option>
            @foreach($viewData["categories"] as $categorie)
              <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                {{ $categorie->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12">
          <label class="form-label">Description</label>
          <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
        </div>
      </div>

      <div class="text-end mt-3">
        <button type="submit" class="btn btn-success">
          <i class="bi-plus-circle me-1"></i> Add Product
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Filter Section -->
<div class="card mb-4 shadow-sm">
  <div class="card-header bg-light fw-bold">Filters</div>
  <div class="card-body">
    <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3 align-items-end">
      <div class="col-md-4">
        <label for="categorie_id" class="form-label">Category</label>
        <select name="categorie_id" id="categorie_id" class="form-select">
          <option value="">All categories</option>
          @foreach($viewData["categories"] as $category)
            <option value="{{ $category->id }}" {{ request('categorie_id') == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <label for="fournisseur_id" class="form-label">Supplier</label>
        <select name="fournisseur_id" id="fournisseur_id" class="form-select">
          <option value="">All suppliers</option>
          @foreach($viewData["fournisseurs"] as $fournisseur)
            <option value="{{ $fournisseur->id }}" {{ request('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
              {{ $fournisseur->raison_social }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4 form-check mt-4">
        <input type="checkbox" class="form-check-input" id="on_sale" name="on_sale" value="1" {{ request('on_sale') ? 'checked' : '' }}>
        <label class="form-check-label" for="on_sale">On sale only</label>
      </div>

      <div class="col-12 text-end">
        <button type="submit" class="btn btn-outline-primary">
          <i class="bi-filter me-1"></i> Apply Filters
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Product Table -->
<div class="card shadow-sm">
  <div class="card-header bg-dark text-white fw-bold">
    Manage Products
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>Image</th> 
            <th>ID</th>
            <th>Name</th>
            <th>Price (€)</th>
            <th>Stock</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($viewData["products"] as $product)
          <tr>
            <td>
              @if ($product->image)
                <img src="{{ asset('storage/images/' . $product->image) }}" alt="image" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
              @else
                <span class="text-muted">No image</span>
              @endif
            </td>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ number_format($product->price, 2) }} €</td>
            <td>{{ $product->quantity_store }}</td>
            <td>{{ optional($product->categorie)->name }}</td>
            <td>{{ optional($product->fournisseur)->raison_social }}</td>
            <td>
              <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                <i class="bi-pencil-square"></i>
              </a>
            </td>
            <td>
              <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" onsubmit="return confirm('Confirm deletion?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">
                  <i class="bi-trash3"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>        
      </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
      {{ $viewData['products']->links() }}
    </div>

  </div>
</div>

@endsection
