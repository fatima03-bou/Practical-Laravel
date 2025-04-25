@extends('layouts.admin')
@section('title', $viewData["title"])

@section('content')
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-warning text-white text-center fw-bold">
    <i class="bi bi-pencil-square me-2"></i> Edit Product
  </div>

  <div class="card-body">
    @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>- {{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.product.update', ['id'=> $viewData['product']->id]) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label"><i class="bi bi-box-seam me-1"></i> Name</label>
          <input name="name" value="{{ $viewData['product']->name }}" type="text" class="form-control shadow-sm" id="name">
        </div>

        <div class="col-md-6 mb-3">
          <label for="price" class="form-label"><i class="bi bi-currency-dollar me-1"></i> Price</label>
          <input name="price" value="{{ $viewData['product']->price }}" type="number" class="form-control shadow-sm" id="price">
        </div>
      </div>

      <div class="mb-3">
        <label for="image" class="form-label"><i class="bi bi-image-fill me-1"></i> Product Image</label>
        <input class="form-control shadow-sm" type="file" name="image" id="image">
      </div>

      <div class="mb-3">
        <label for="description" class="form-label"><i class="bi bi-card-text me-1"></i> Description</label>
        <textarea class="form-control shadow-sm" name="description" id="description" rows="4">{{ $viewData['product']->description }}</textarea>
      </div>

      <div class="mb-4">
        <label for="category_id" class="form-label"><i class="bi bi-tags me-1"></i> Category</label>
        <select name="category_id" id="category_id" class="form-select shadow-sm">
          <option value="-1" disabled>Choose a category</option>
          @foreach($viewData['categories'] as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $viewData['product']->category_id) == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-success px-4">
          <i class="bi bi-check2-circle me-1"></i> Save Changes
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
