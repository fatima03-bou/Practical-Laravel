@extends('layouts.admin')
@section('title', $viewData["title"])
@section('content')
<div class="card mb-4">
  <div class="card-header">
    Create Product
  </div>
  <div class="card-body">
    @if($errors->any())
    <div class="alert alert-danger">
      <ul class="list-unstyled">
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
            <label for="name" class="form-label">Name:</label>
            <input id="name" name="name" value="{{ old('name') }}" type="text" class="form-control" required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input id="price" name="price" value="{{ old('price') }}" type="number" step="0.01" class="form-control" required>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input id="image" class="form-control" type="file" name="image">
          </div>
        </div>
        <div class="col-md-6"></div>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Description:</label>
        <textarea id="description" class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
      </div>

      <div class="mb-3">
        <label for="categorie_id" class="form-label">Category:</label>
        <select id="categorie_id" name="categorie_id" class="form-select" required>
          @foreach ($viewData['categories'] as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="quantity_store" class="form-label">Quantity in Stock:</label>
            <input id="quantity_store" name="quantity_store" value="{{ old('quantity_store') }}" type="number" class="form-control" required min="1">
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label for="fournisseur_id" class="form-label">Fournisseur:</label>
            <select id="fournisseur_id" name="fournisseur_id" class="form-select">
              <option value="">Select Fournisseur</option>
              @foreach($viewData['fournisseurs'] as $fournisseur)
                <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                  {{ $fournisseur->raison }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
@endsection
