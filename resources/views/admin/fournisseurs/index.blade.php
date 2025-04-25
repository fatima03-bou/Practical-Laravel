@extends('layouts.admin')
@section('title', $viewData["title"])
@section('content')

<!-- Create Fournisseur Section -->
<div class="card shadow-lg rounded-3 mb-4">
  <div class="card-header bg-primary text-white rounded-3">
    <div class="card-header-icon icon-success">
      <i class="bi bi-building-add"></i>
    </div>
    <h5 class="m-0 font-weight-bold">Create Supplier</h5>
    <p class="small text-white">Fill in the details below to create a new supplier</p>
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

    <form method="POST" action="{{ route('fournisseurs.store') }}">
      @csrf
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Raison Sociale (Company Name):</label>
          <div class="input-group rounded-3 shadow-sm">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-building"></i></span>
            <input name="raison_social" value="{{ old('raison_social') }}" type="text" class="form-control rounded-3 border-start-0" placeholder="Company Name">
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Adresse (Address):</label>
          <div class="input-group rounded-3 shadow-sm">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-geo-alt"></i></span>
            <input name="adresse" value="{{ old('adresse') }}" type="text" class="form-control rounded-3 border-start-0" placeholder="Address">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Telephone (Phone Number):</label>
          <div class="input-group rounded-3 shadow-sm">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone"></i></span>
            <input name="tele" value="{{ old('tele') }}" type="text" class="form-control rounded-3 border-start-0" placeholder="Phone Number">
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Email:</label>
          <div class="input-group rounded-3 shadow-sm">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
            <input name="email" value="{{ old('email') }}" type="email" class="form-control rounded-3 border-start-0" placeholder="Email Address">
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Description:</label>
        <div class="input-group rounded-3 shadow-sm">
          <span class="input-group-text bg-light border-end-0"><i class="bi bi-text-paragraph"></i></span>
          <textarea name="description" rows="3" class="form-control rounded-3 border-start-0" placeholder="Provide a brief description of the supplier">{{ old('description') }}</textarea>
        </div>
      </div>

      <button type="submit" class="btn btn-success rounded-3 px-4 py-2">
        <i class="bi bi-check-circle me-2"></i>Create Supplier
      </button>
    </form>
  </div>
</div>

<!-- Manage Fournisseurs Section -->
<div class="card shadow-lg rounded-3">
  <div class="card-header bg-secondary text-white rounded-3">
    <div class="card-header-icon icon-primary">
      <i class="bi bi-buildings"></i>
    </div>
    <h5 class="m-0 font-weight-bold">Manage Suppliers</h5>
    <p class="small text-white">View, edit, or delete existing suppliers</p>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>COMPANY</th>
            <th>CONTACT</th>
            <th>ADDRESS</th>
            <th>DESCRIPTION</th>
            <th class="table-action">ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($viewData["fournisseurs"] as $fournisseur)
          <tr>
            <td>{{ $fournisseur->id }}</td>
            <td><span class="fw-medium">{{ $fournisseur->raison_social }}</span></td>
            <td>
              <div><i class="bi bi-telephone-fill text-primary me-1"></i> {{ $fournisseur->tele }}</div>
              <div><i class="bi bi-envelope-fill text-primary me-1"></i> {{ $fournisseur->email }}</div>
            </td>
            <td>{{ $fournisseur->adresse }}</td>
            <td>{{ $fournisseur->description }}</td>
            <td class="table-action">
              <div class="btn-group" role="group">
                <a href="{{ route('fournisseurs.edit', $fournisseur->id) }}" class="btn btn-sm btn-warning rounded-3" data-bs-toggle="tooltip" title="Edit Supplier">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('fournisseurs.destroy', $fournisseur->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger rounded-3" data-bs-toggle="tooltip" title="Delete Supplier" onclick="return confirm('Are you sure you want to delete this supplier?')">
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
