@extends('layouts.admin')

@section('title', 'Edit Fournisseur')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="card shadow">
      <div class="card-header">
        <div class="card-header-icon icon-warning">
          <i class="bi bi-building-gear"></i>
        </div>
        <h5 class="m-0 font-weight-bold">Edit Supplier</h5>
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
              <label class="form-label">Raison Social</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-building"></i></span>
                <input type="text" name="raison_social" class="form-control" value="{{ old('raison_social', $viewData['fournisseur']->raison_social) }}">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Adresse</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $viewData['fournisseur']->adresse) }}">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Telephone</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                <input type="text" name="tele" class="form-control" value="{{ old('tele', $viewData['fournisseur']->tele) }}">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control" value="{{ old('email', $viewData['fournisseur']->email) }}">
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Description</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-text-paragraph"></i></span>
              <textarea name="description" class="form-control" rows="3">{{ old('description', $viewData['fournisseur']->description) }}</textarea>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning">
              <i class="bi bi-check-circle me-2"></i>Update Supplier
            </button>
            <a href="{{ url('/admin/fournisseurs') }}" class="btn btn-secondary">
              <i class="bi bi-arrow-left me-2"></i>Back to Suppliers
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
