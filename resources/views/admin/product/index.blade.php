@extends('layouts.admin')


@section('title', $viewData['title'])

@section('content')

<div class="card mb-4">
  <div class="card-header">
    {{__('message.create_prod')}}
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>- {{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">{{__('message.name')}}:</label>
          <input name="name" value="{{ old('name') }}" type="text" class="form-control" required>
        </div>
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{__('message.price')}}:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="price" value="{{ old('price') }}" type="number" min="1"   step="0.01" class="form-control">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{__('message.discount_price')}}:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="discount_price" value="{{ old('discount_price') }}" type="number" min="1" step="0.01" class="form-control">
            </div>
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">{{__('message.image')}}:</label>
          <input class="form-control" type="file" name="image">
        </div>
      </div>
      <div class="col">
        <div class="mb-3 row">
          <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{__('message.quantity')}}:</label>
          <div class="col-lg-10 col-md-6 col-sm-12">
            <input name="quantity_store" value="{{ old('quantity_store') }}" type="number" min="1" class="form-control">
          </div>
        </div>
      </div>


      <div class="mb-3 row">
        <label class="col-lg-2 col-form-label">{{__('message.fourni')}}:</label>
        <div class="col-lg-10">
          <select name="fournisseur_id" class="form-control">
            <option value="">-- {{__('message.select_fourni')}} --</option>
            @foreach($viewData["fournisseurs"] as $fournisseur)
              <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                {{ $fournisseur->raison }}
              </option>
            @endforeach
          </select>
        </div>
      </div>


      <div class="mb-3 row">
        <label class="col-lg-2 col-form-label">{{__('message.cat')}}:</label>
        <div class="col-lg-10">
          <select name="categorie_id" class="form-control">
            <option value="">-- {{__('message.select_cat')}} --</option>
            @foreach($viewData["categories"] as $categorie)
              <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                {{ $categorie->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-form-label">{{__('message.qte_instock')}}:</label>
            <div class="col-lg-10">
              <input name="quantity_store" value="{{ old('quantity_store') }}" type="number" class="form-control">
            </div>
          </div>
        </div>
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-form-label">{{__('message.fourni')}}:</label>
            <div class="col-lg-10">
              <select name="fournisseur_id" class="form-control">
                <option value="">{{__('message.select_fourni')}}</option>
                @foreach($viewData["fournisseurs"] as $fournisseur)
                  <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                    {{ $fournisseur->raison }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">{{__('message.description')}}</label>
        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
      </div>

      <button type="submit" class="btn btn-primary">{{__('message.submit')}}</button>
    </form>
  </div>
</div>

<!-- Section de filtres -->
<div class="filter-section card mb-4">
  <div class="card-header">{{__('message.filters')}}</div>
  <div class="card-body">
    <form action="{{ route('admin.products.index') }}" method="GET">
      <div class="form-group mb-3">
        <label for="categorie_id">{{__('message.cat')}}</label>
        <select name="categorie_id" id="categorie_id" class="form-control">
          <option value="">{{__('message.all_cat')}}</option>

          @foreach($viewData['categories'] as $categorie)
          <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
              {{ $categorie->name }}
            </option>
          @endforeach
        </select>
      </div>


      <div class="form-group mb-3">
        <label for="fournisseur_id">{{__('message.fourni')}}</label>
        <select name="fournisseur_id" id="fournisseur_id" class="form-control">
          <option value="">{{__('message.all_fourni')}}</option>
          @foreach($viewData["fournisseurs"] as $fournisseur)
            <option value="{{ $fournisseur->id }}" {{ request('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
              {{ $fournisseur->raison }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4 form-check mt-4">
        <input type="checkbox" class="form-check-input" id="on_sale" name="on_sale" value="1" {{ request('on_sale') ? 'checked' : '' }}>
        <label class="form-check-label" for="on_sale">{{__('message.produits_en_solde_uniquement')}}</label>
      </div>

      <button type="submit" class="btn btn-primary">{{__('message.filter')}}</button>
    </form>
  </div>
</div>

<!-- Table de gestion des produits -->
<div class="card">
  <div class="card-header">
    {{__('message.manage_products')}}
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">{{__('message.name')}}</th>
            <th scope="col">{{__('message.price')}} (€)</th>
            <th scope="col">{{__('message.qte_instock')}}</th>
            <th scope="col">{{__('message.cat')}}</th>
            <th scope="col">{{__('message.fourni')}}</th>
            <th scope="col">{{__('message.edit')}}</th>
            <th scope="col">{{__('message.delete')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($viewData["products"] as $product)
          <tr>
            <td>
              @if ($product->image)
                <img src="{{ asset('storage/images/' . $product->image) }}" alt="image" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
              @else
                <span class="text-muted">{{__('message.pas_image')}}</span>
              @endif
            </td>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ number_format($product->price, 2) }} €</td>
            <td>{{ $product->quantity_store }}</td>
            <td>{{ optional($product->categorie)->name }}</td>
            <td>{{ optional($product->fournisseur)->raison }}</td>
            <td>
              <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                <i class="bi-pencil-square"></i>
              </a>
            </td>
            <td>
              <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" onsubmit="return confirm('{{__('message.confirm_delete')}}')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">
                  <i class="bi-trash3"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
