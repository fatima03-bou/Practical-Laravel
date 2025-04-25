@extends('layouts.admin')
@section('title', $viewData["title"])

@section('content')
<div class="card shadow-sm mb-4">
  <div class="card-header bg-dark text-white text-center">
    <h3>Create Product</h3>
  </div>
  <div class="card-body">
    @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
        <li>- {{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input name="name" type="text" class="form-control" value="{{ old('name') }}" id="name" placeholder="Enter product name">
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input name="price" type="number" class="form-control" value="{{ old('price') }}" id="price" placeholder="Enter price">
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="image" class="form-label">Product Image</label>
        <input class="form-control" type="file" name="image" id="image">
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description" rows="4" placeholder="Enter product description">{{ old('description') }}</textarea>
      </div>

      <div class="mb-3">
        <label for="fournisseur_id" class="form-label">Supplier</label>
        <select name="fournisseur_id" id="fournisseur_id" class="form-select">
          <option value="-1" disabled selected>Select a supplier</option>
          @foreach($viewData['fournisseurs'] as $fournisseur)
          <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
            {{ $fournisseur->raison_social }}
          </option>
          @endforeach
        </select>
      </div>
      
      <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select name="category_id" id="category_id" class="form-select">
          <option value="-1" disabled selected>Select a category</option>
          @foreach($viewData['categories'] as $category)
          <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
          </option>
          @endforeach
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-header bg-info text-white text-center">
    <h3>Product Management</h3>
  </div>
  <div class="card-body">
    <form method="GET" action="{{ route('admin.product.index') }}" class="d-flex align-items-center mb-4">
      <div class="mb-3 me-3">
        <label for="category_id_filter" class="form-label">Category</label>
        <select name="category_id" id="category_id_filter" class="form-select" onchange="this.form.submit()">
          <option value="">All Categories</option>
          @foreach($viewData['categories'] as $category)
          <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
          </option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label for="fournisseur_id_filter" class="form-label">Supplier</label>
        <select name="fournisseur_id" id="fournisseur_id_filter" class="form-select" onchange="this.form.submit()">
          <option value="">All Suppliers</option>
          @foreach($viewData['fournisseurs'] as $fournisseur)
          <option value="{{ $fournisseur->id }}" {{ request('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
            {{ $fournisseur->raison_social }}
          </option>
          @endforeach
        </select>
      </div>
    </form>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
      <form action="{{ route('admin.product.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
        @csrf
        <label for="file" class="form-label me-2">Import Excel:</label>
        <input type="file" name="file" class="form-control me-3">
        <button type="submit" class="btn btn-secondary">Import</button>
      </form>
      <a href="{{ route('admin.product.export') }}" class="btn btn-success">Export</a>
    </div>

    <div class="table-responsive rounded shadow-sm">
      <table class="table table-bordered table-striped table-hover align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th> 
            <th scope="col">Category</th>
            <th scope="col">Supplier</th>
            <th scope="col">Stock</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($viewData["products"] as $product)
          <tr class="
              @if($product->quantity_store == 0)
                bg-danger text-white
              @elseif($product->quantity_store < 10)
                bg-warning-subtle
              @else
                bg-success-subtle
              @endif
            ">
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }} DH</td> 
            <td>{{ $product->category->name ?? 'No category' }}</td>
            <td>{{ $product->fournisseurs->raison_social ?? 'No supplier' }}</td>
            <td class="fw-bold">{{ $product->quantity_store }}</td>
            <td>
              <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('admin.product.edit', ['id'=> $product->id]) }}" class="btn btn-sm btn-outline-warning">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('admin.product.delete', $product->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i> Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
        
      </table>
    </div>
    
  </div>
</div>
@endsection
