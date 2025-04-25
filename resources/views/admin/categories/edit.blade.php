@extends('layouts.admin')
@section('title', $viewData["title"])
@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow">
      <div class="card-header">
        <div class="card-header-icon icon-warning">
          <i class="bi bi-pencil-square"></i>
        </div>
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

        <form method="POST" action="{{ route('admin.categorie.update', ['id' => $viewData['categorie']->id]) }}">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label">Name:</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-tag"></i></span>
              <input name="name" value="{{ $viewData['categorie']->name }}" type="text" class="form-control">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Description:</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-text-paragraph"></i></span>
              <textarea name="description" rows="3" class="form-control">{{ $viewData['categorie']->description }}</textarea>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning">
              <i class="bi bi-check-circle me-2"></i>Update Category
            </button>
            <a href="{{ route('admin.categorie.index') }}" class="btn btn-secondary">
              <i class="bi bi-arrow-left me-2"></i>Back to Categories
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
