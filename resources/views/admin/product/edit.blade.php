@extends('layouts.admin')
@section('title', $viewData["title"])
@section('content')
<div class="card mb-4">
  <div class="card-header">
    {{__('message.edit_prod')}}
  </div>
  <div class="card-body">
    @if($errors->any())
    <ul class="alert alert-danger list-unstyled">
      @foreach($errors->all() as $error)
      <li>- {{ $error }}</li>
      @endforeach
    </ul>
    @endif

    <form method="POST" action="{{ route('admin.product.update', ['id' => $viewData['product']->id]) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{__('message.name')}}:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="name" value="{{ $viewData['product']->name }}" type="text" class="form-control">
            </div>
          </div>
        </div>
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{__('message.price')}}:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="price" value="{{ $viewData['product']->price }}" type="number" class="form-control">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{__('message.discount_price')}}:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="discount_price" value="{{ $viewData['product']->getDiscountedPrice() }}" type="number" class="form-control">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{__('message.image')}}:</label>
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
        <label class="form-label">{{__('message.description')}}</label>
        <textarea class="form-control" name="description" rows="3">{{ $viewData['product']->description }}</textarea>
      </div>

      <div class="mb-3 row">
        <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{__('message.qte_instock')}}:</label>
        <div class="col-lg-10 col-md-6 col-sm-12">
          <input name="quantity_store" value="{{ old('quantity_store', $viewData['product']->quantity_store) }}" type="number" class="form-control">
        </div>
      </div>

      <div class="mb-3 row">
        <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{__('message.fourni')}}:</label>
        <div class="col-lg-10 col-md-6 col-sm-12">
          <select name="fournisseur_id" class="form-control">
            <option value="">{{__('message.select_fourni')}}</option>
            @foreach ($viewData['fournisseurs'] as $fournisseur)
              <option value="{{ $fournisseur->id }}"
                {{ $viewData['product']->fournisseur_id == $fournisseur->id ? 'selected' : '' }}>
                {{ $fournisseur->raison}}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="mb-3 row">
        <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{__('message.cat')}}:</label>
        <div class="col-lg-10 col-md-6 col-sm-12">
          <select name="categorie_id" class="form-control">
            @foreach ($viewData['categories'] as $categorie)
              <option value="{{ $categorie->id }}"
                {{ $viewData['product']->categorie_id == $categorie->id ? 'selected' : '' }}>
                {{ $categorie->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">{{__('message.edit')}}</button>
    </form>
  </div>
</div>
@endsection
