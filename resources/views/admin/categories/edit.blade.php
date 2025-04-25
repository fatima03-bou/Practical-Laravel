@extends('layouts.admin')
@section('title', $viewData["title"])

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-lg rounded-3">
      <div class="card-header bg-primary text-white d-flex align-items-center">
        <i class="bi bi-pencil-square me-3 text-white"></i>
        <h5 class="m-0 font-weight-bold">Edit Category</h5>
      </div>
      <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.category.update', ['id' => $viewData['category']->id]) }}">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label class="form-label text-muted">Name:</label>
            <div class="input-group rounded-3 shadow-sm">
              <span class="input-group-text bg-light border-end-0"><i class="bi bi-tag"></i></span>
              <input name="name" value="{{ $viewData['category']->name }}" type="text" class="form-control rounded-3 border-start-0" placeholder="Enter category name">
            </div>
          </div>
          <div class="mb-4">
            <label class="form-label text-muted">Description:</label>
            <div class="input-group rounded-3 shadow-sm">
              <span class="input-group-text bg-light border-end-0"><i class="bi bi-text-paragraph"></i></span>
              <textarea name="description" rows="3" class="form-control rounded-3 border-start-0" placeholder="Enter category description">{{ $viewData['category']->description }}</textarea>
            </div>
          </div>
          <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-warning rounded-3 px-4 py-2">
              <i class="bi bi-check-circle me-2"></i>Update Category
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-3 px-4 py-2">
              <i class="bi bi-arrow-left me-2"></i>Back to Categories
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
