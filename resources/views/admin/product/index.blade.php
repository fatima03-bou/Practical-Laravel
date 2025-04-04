@extends('layouts.admin')
<<<<<<< HEAD
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
=======

@section('title', $viewData["title"])

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
>>>>>>> feature_gestion_soldes

    <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Name:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="name" value="{{ old('name') }}" type="text" class="form-control">
            </div>
          </div>
        </div>
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Price:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="price" value="{{ old('price') }}" type="number" step="0.01" class="form-control">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Discount Price:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="discount_price" value="{{ old('discount_price') }}" type="number" step="0.01" class="form-control">
            </div>
          </div>
        </div>
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Image:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input class="form-control" type="file" name="image">
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
    <form action="{{ route('products.index') }}" method="GET">
      <div class="form-group mb-3">
        <label for="category_id">Catégorie</label>
        <select name="category_id" id="category_id" class="form-control">
          <option value="">Toutes les catégories</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
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

<div class="card">
  <div class="card-header">
    Manage Products
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Price</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($viewData["products"] as $product)
        <tr>
          <td>{{ $product->getId() }}</td>
          <td>{{ $product->getName() }}</td>
          <td>
            @if($product->discount_price && $product->discount_price < $product->price)
              <span class="original-price text-decoration-line-through">{{ number_format($product->price, 2) }} €</span>
              <span class="discounted-price fw-bold text-danger">{{ number_format($product->discount_price, 2) }} €</span>
            @else
              <span class="price">{{ number_format($product->price, 2) }} €</span>
            @endif
          </td>
          <td>
            <a class="btn btn-primary" href="{{ route('admin.product.edit', ['id' => $product->getId()]) }}">
              <i class="bi-pencil"></i>
            </a>
          </td>
          <td>
            <form action="{{ route('admin.product.delete', $product->getId()) }}" method="POST">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger">
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

@endsection