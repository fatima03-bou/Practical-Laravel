@extends('layouts.admin')
@section('title', 'Créer une remise')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card border-0 shadow-lg rounded-4">
      <div class="card-header bg-gradient-primary text-white d-flex align-items-center">
        <i class="fa-solid fa-percent fa-xl me-3"></i>
        <h5 class="mb-0 text-gray-700">Créer une remise</h5> {{-- Changement couleur du titre --}}
      </div>
      <div class="card-body bg-light rounded-bottom-4">
        <form action="{{ route('discounts.store') }}" method="POST">
          @csrf

          {{-- Type de remise --}}
          <div class="mb-4">
            <label for="type" class="form-label fw-bold">Type de remise</label>
            <div class="input-group">
              <span class="input-group-text bg-white"><i class="fa-solid fa-tags"></i></span>
              <select name="type" id="type" class="form-select shadow-sm" required>
                <option value="all">Tous les produits</option>
                <option value="category">Par catégorie</option>
                <option value="product">Par produit</option>
              </select>
            </div>
          </div>

          {{-- Catégorie --}}
          <div id="category-div" class="mb-4 d-none">
            <label for="category_id" class="form-label fw-bold">Catégorie</label>
            <div class="input-group">
              <span class="input-group-text bg-white"><i class="fa-solid fa-folder-tree"></i></span>
              <select name="category_id" class="form-select shadow-sm">
                @foreach(\App\Models\Categorie::all() as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          {{-- Produit --}}
          <div id="product-div" class="mb-4 d-none">
            <label for="product_id" class="form-label fw-bold">Produit</label>
            <div class="input-group">
              <span class="input-group-text bg-white"><i class="fa-solid fa-box-open"></i></span>
              <select name="product_id" class="form-select shadow-sm">
                @foreach(\App\Models\Product::all() as $product)
                  <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          {{-- Pourcentage --}}
          <div class="mb-4">
            <label for="percentage" class="form-label fw-bold">Pourcentage (%)</label>
            <div class="input-group">
              <span class="input-group-text bg-white"><i class="fa-solid fa-percent"></i></span>
              <input type="number" name="percentage" class="form-control shadow-sm" required step="0.1" min="0" max="100" placeholder="Entrez le pourcentage de remise">
            </div>
          </div>

          {{-- Dates --}}
          <div class="row">
            <div class="col-md-6 mb-4">
              <label for="start_date" class="form-label fw-bold">Date de début</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="fa-regular fa-calendar-days"></i></span>
                <input type="date" name="start_date" class="form-control shadow-sm" required>
              </div>
            </div>

            <div class="col-md-6 mb-4">
              <label for="end_date" class="form-label fw-bold">Date de fin</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="fa-solid fa-calendar-check"></i></span>
                <input type="date" name="end_date" class="form-control shadow-sm" required>
              </div>
            </div>
          </div>

          <div class="d-grid mt-3">
            <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">
              <i class="fa-solid fa-circle-plus me-2"></i> Ajouter la remise
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Script pour afficher/masquer les champs dynamiquement --}}
<script>
  document.getElementById('type').addEventListener('change', function () {
    let type = this.value;
    document.getElementById('category-div').classList.toggle('d-none', type !== 'category');
    document.getElementById('product-div').classList.toggle('d-none', type !== 'product');
  });
</script>
@endsection
