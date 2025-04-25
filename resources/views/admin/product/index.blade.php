@extends('layouts.admin')
@section('title', $viewData["title"])


@section('content')
<div class="card mb-4">
  <div class="card-header">Create Products</div>
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
              <input name="price" value="{{ old('price') }}" type="number" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
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
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Category:</label>
        <div class="col-lg-10 col-md-6 col-sm-12">
          <select name="categorie_id" class="form-control">
            <option value="-1" disabled selected>Choose a category</option>
            @foreach($viewData['categories'] as $categorie)
                <option value="{{ $categorie['id'] }}" 
                    {{ old('categorie_id', $product->categorie_id ?? '') == $categorie->id ? 'selected' : '' }}>
                    {{ $categorie->name }}
                </option>
            @endforeach
          </select>
        </div>
      </div>
    
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">Manage Products</div>
  <div class="card-body">
    <label for="file" class="form-label fw-bold">Filter By:</label>
    <div class="d-flex flex-wrap gap-3 align-items-center mb-3">

      <!-- Category Filter -->
      <form method="GET" action="{{ route('admin.product.index') }}" class="d-flex align-items-center">
        <label for="categorie_id" class="me-2 fw-bold">Category:</label>
        <select name="categorie_id" id="categorie_id" class="form-select" onchange="this.form.submit()">
          <option value="">All Categories</option>
          @foreach($viewData['categories'] as $categorie)
            <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
              {{ $categorie->name }}
            </option>
          @endforeach
        </select>
      </form>

      <!-- Fournisseur Filter -->
      <form method="GET" action="{{ route('admin.product.index') }}" class="d-flex align-items-center">
        <label for="fournisseur_id" class="me-2 fw-bold">Fournisseur:</label>
        <select name="fournisseur_id" id="fournisseur_id" class="form-select" onchange="this.form.submit()">
          <option value="">All Fournisseurs</option>
          @foreach($viewData['fournisseurs'] as $fournisseur)
            <option value="{{ $fournisseur->id }}" {{ request('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
              {{ $fournisseur->raison_social }}
            </option>
          @endforeach
        </select>
      </form>
    </div>

    <!-- Import Form -->
    <div class="card p-3">
      <form action="{{ route('admin.product.import') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-wrap gap-3 align-items-center ">
        @csrf
        <div class="d-flex flex-column">
          <label for="file" class="form-label fw-bold">Choose Excel File:</label>
          <input type="file" name="file" class="form-control" required>
        </div>
        <div class="d-flex gap-2 pt-4">
          <button type="submit" class="btn btn-primary">Import</button>
          <a href="{{ route('admin.product.export') }}" class="btn btn-success">Export</a>
        </div>
      </form>
    </div>

    <!-- Product Table -->
    <table class="table table-bordered table-striped mt-3">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Category</th>
          <th scope="col">Fournisseur</th>
          <th scope="col">Quantity</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($viewData["products"] as $product)
          <tr class="
            @if($product->quantity_store == 0)
              table-danger text-white
            @elseif($product->quantity_store < 10)
              table-warning text-dark
            @else
              table-success text-white
            @endif
          ">
            <td>{{ $product->getId() }}</td>
            <td>{{ $product->getName() }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->fournisseur->raison_social }}</td>
            <td>{{ $product->quantity_store }}</td>
            <td>
              <a class="btn btn-primary" href="{{ route('admin.product.edit', ['id'=> $product->getId()]) }}">
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
