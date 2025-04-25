@extends('layouts.admin')
@section('title', 'Créer une remise')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow">
      <div class="card-header">
        <div class="card-header-icon icon-success">
          <i class="bi bi-percent"></i>
        </div>
        <h5 class="m-0 font-weight-bold">Créer une remise</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('discounts.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="type" class="form-label">Type de remise</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-tag"></i></span>
              <select name="type" id="type" class="form-select" required>
                <option value="all">Tous les produits</option>
                <option value="category">Par catégorie</option>
                <option value="product">Par produit</option>
              </select>
            </div>
          </div>

          <div id="category-div" class="mb-3 d-none">
            <label for="category_id" class="form-label">Catégorie</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-folder"></i></span>
              <select name="category_id" class="form-select">
                @foreach(\App\Models\Categorie::all() as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div id="product-div" class="mb-3 d-none">
            <label for="product_id" class="form-label">Produit</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-box"></i></span>
              <select name="product_id" class="form-select">
                @foreach(\App\Models\Product::all() as $product)
                  <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label for="percentage" class="form-label">Pourcentage (%)</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-percent"></i></span>
              <input type="number" name="percentage" class="form-control" required step="0.1" min="0" max="100" placeholder="Enter discount percentage">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="start_date" class="form-label">Date de début</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                <input type="date" name="start_date" class="form-control" required>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="end_date" class="form-label">Date de fin</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                <input type="date" name="end_date" class="form-control" required>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Ajouter la remise
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('type').addEventListener('change', function () {
    let type = this.value;
    document.getElementById('category-div').classList.toggle('d-none', type !== 'category');
    document.getElementById('product-div').classList.toggle('d-none', type !== 'product');
  });
</script>
@endsection
