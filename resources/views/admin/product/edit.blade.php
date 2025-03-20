@extends('layouts.admin')
@section('title', $viewData["title"])
@section('content')
<div class="card mb-4">
  <div class="card-header">
    Edit Product
  </div>
  <div class="card-body">
    @if($errors->any())
    <ul class="alert alert-danger list-unstyled">
      @foreach($errors->all() as $error)
      <li>- {{ $error }}</li>
      @endforeach
    </ul>
    @endif

    <form method="POST" action="{{ route('admin.product.update', ['id'=> $viewData['product']->id]) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Name:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="name" value="{{ $viewData['product']->name }}" type="text" class="form-control">
            </div>
          </div>
        </div>
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Price:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="price" value="{{ $viewData['product']->price }}" type="number" class="form-control">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Discount Price:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="discount_price" value="{{ $viewData['product']->getDiscountPrice() }}" type="number" class="form-control">
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
        <div class="col">
          &nbsp;
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3">{{ $viewData['product']->description }}</textarea>
      </div>

      <div class="mb-3 row">
        <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Quantity in Stock:</label>
        <div class="col-lg-10 col-md-6 col-sm-12">
          <input name="quantity_store" value="{{ old('quantity_store', $viewData['product']->quantity_store) }}" type="number" class="form-control">
        </div>
      </div>

    <div class="mb-3 row">
      <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Fournisseur:</label>
      <div class="col-lg-10 col-md-6 col-sm-12">
        <select name="fournisseur_id" class="form-control">
          <option value="">Select Fournisseur</option>
          @foreach ($viewData['fournisseurs'] as $fournisseur)
            <option value="{{ $fournisseur->id }}" 
              {{ $viewData['product']->fournisseur_id == $fournisseur->id ? 'selected' : '' }}>
              {{ $fournisseur->raison }}
            </option>
          @endforeach
        </select>
      </div>
    </div>


      <!-- Category Selection -->
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Category:</label>
        <div class="col-lg-10 col-md-6 col-sm-12">
          <select name="categorie_id" class="form-control">
            @foreach ($viewData['categories'] as $category)
              <option value="{{ $category->id }}" 
                {{ $viewData['product']->categorie_id == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Edit</button>
    </form>
  </div>
</div>
@endsection