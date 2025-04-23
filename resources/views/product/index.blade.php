@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="mb-3">
  <form method="GET" action="{{ route('product.index') }}">
    <div class="row">
      <div class="col-md-6">
        <label for="categorie_id" class="form-label">{{__('message.filter_bycat')}}:</label>
        <select name="categorie_id" class="form-select" onchange="this.form.submit()">
          <option value="">{{__('message.all_cat')}}</option>
          @foreach ($viewData['categories'] as $categorie)
            <option value="{{ $categorie->id }}"
              @if(request('categorie_id') == $categorie->id) selected @endif>
              {{ $categorie->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label for="fournisseur_id" class="form-label">{{__('message.filter_bysup')}}:</label>
        <select name="fournisseur_id" class="form-select" onchange="this.form.submit()">
          <option value="">{{__('message.all_fourni')}}</option>
          @foreach ($viewData['fournisseurs'] as $fournisseur)
            <option value="{{ $fournisseur->id }}"
              @if(request('fournisseur_id') == $fournisseur->id) selected @endif>
              {{ $fournisseur->raison}}
            </option>
          @endforeach
        </select>
      </div>
    </div>
  </form>
</div>

<div class="row">
  @foreach ($viewData["products"] as $product)
    <div class="col-md-4 col-lg-3 mb-2">
      <div class="card">
        <img src="{{ Storage::url('images/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top">
        <div class="card-body text-center">
          <a href="{{ route('product.show', ['id'=> $product->getId()]) }}" class="btn bg-primary text-white">
            {{ $product->getName() }}
          </a>
          <p>
            <span>{{__('message.qte_instock')}}: {{ $product->getQuantityStore() }}</span>
          </p>
          @if ($product->getQuantityStore() == 0)
            <p class="badge bg-danger">{{__('message.out_of_stock')}}</p>
          @endif
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
