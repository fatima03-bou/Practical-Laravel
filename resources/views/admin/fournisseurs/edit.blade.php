@extends('layouts.admin')

@section('title', 'Edit Supplier')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-lg rounded-3 mb-4">
      <div class="card-header bg-warning text-white rounded-3">
        <div class="card-header-icon icon-warning">
          <i class="bi bi-building-gear"></i>
        </div>
        <h5 class="m-0 font-weight-bold">Edit Supplier</h5>
        <p class="small text-white">Update the details of the selected supplier</p>
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

        <form method="POST" action="{{ url('/admin/fournisseurs/' . $viewData['fournisseur']->id) }}">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Raison Sociale (Company Name):</label>
              <div class="input-group shadow-sm rounded-3">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-building"></i></span>
                <input type="text" name="raison_social" class="form-control rounded-3 border-start-0" value="{{ old('raison_social', $viewData['fournisseur']->raison_social) }}" placeholder="Company Name">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Adresse (Address):</label>
              <div class="input-group shadow-sm rounded-3">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-geo-alt"></i></span>
                <input type="text" name="adresse" class="form-control rounded-3 border-start-0" value="{{ old('adresse', $viewData['fournisseur']->adresse) }}" placeholder="Address">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Telephone (Phone Number):</label>
              <div class="input-group shadow-sm rounded-3">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone"></i></span>
                <input type="text" name="tele" class="form-control rounded-3 border-start-0" value="{{ old('tele', $viewData['fournisseur']->tele) }}" placeholder="Phone Number">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Email:</label>
              <div class="input-group shadow-sm rounded-3">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control rounded-3 border-start-0" value="{{ old('email', $viewData['fournisseur']->email) }}" placeholder="Email Address">
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Description:</label>
            <div class="input-group shadow-sm rounded-3">
              <span class="input-group-text bg-light border-end-0"><i class="bi bi-text-paragraph"></i></span>
              <textarea name="description" class="form-control rounded-3 border-start-0" rows="3" placeholder="Provide a brief description of the supplier">{{ old('description', $viewData['fournisseur']->description) }}</textarea>
            </div>
          </div>

          <div class="d-flex gap-3">
            <button type="submit" class="btn btn-warning rounded-3 px-4 py-2">
              <i class="bi bi-check-circle me-2"></i>Update Supplier
            </button>
            <a href="{{ url('/admin/fournisseurs') }}" class="btn btn-secondary rounded-3 px-4 py-2">
              <i class="bi bi-arrow-left me-2"></i>Back to Suppliers
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
