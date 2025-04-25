@extends('layouts.admin')
@section('title', $viewData["title"])

@section('content')
<!-- Create Category Section -->
<div class="card shadow mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="bi bi-plus-lg me-2"></i>
    <h5 class="m-0 font-weight-bold">Create Category</h5>
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

    <form method="POST" action="{{ route('admin.categorie.store') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Name:</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-tag"></i></span>
          <input name="name" value="{{ old('name') }}" type="text" class="form-control" placeholder="Category name">
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Description:</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-text-paragraph"></i></span>
          <textarea name="description" rows="3" class="form-control" placeholder="Category description">{{ old('description') }}</textarea>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-2"></i>Create Category
      </button>
    </form>
  </div>
</div>

<!-- Manage Categories Section -->
<div class="card shadow">
  <div class="card-header d-flex align-items-center">
    <i class="bi bi-list-ul me-2"></i>
    <h5 class="m-0 font-weight-bold">Manage Categories</h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>DESCRIPTION</th>
            <th class="table-action">ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($viewData["categories"] as $categorie)
          <tr>
            <td>{{ $categorie["id"] }}</td>
            <td><span class="fw-medium">{{ $categorie["name"] }}</span></td>
            <td>{{ Str::limit($categorie['description'], 50) }}</td>
            <td class="table-action">
              <div class="btn-group" role="group">
                <a href="{{ route('admin.categorie.edit', ['id' => $categorie["id"]]) }}" class="btn btn-sm btn-primary">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('admin.categorie.delete', $categorie["id"]) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-4 d-flex justify-content-center">
      {{ $viewData["categories"]->links('pagination::bootstrap-5') }}
    </div>
  </div>
</div>
@endsection
