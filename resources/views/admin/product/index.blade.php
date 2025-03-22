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
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-form-label">Name:</label>
            <div class="col-lg-10">
              <input name="name" value="{{ old('name') }}" type="text" class="form-control">
            </div>
          </div>
        </div>
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-form-label">Price:</label>
            <div class="col-lg-10">
              <input name="price" value="{{ old('price') }}" type="number" step="0.01" class="form-control">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-form-label">Discount Price:</label>
            <div class="col-lg-10">
              <input name="discount_price" value="{{ old('discount_price') }}" type="number" step="0.01" class="form-control">
            </div>
          </div>
        </div>
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-form-label">Image:</label>
            <div class="col-lg-10">
              <input class="form-control" type="file" name="image">
            </div>
          </div>
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
@endsection
