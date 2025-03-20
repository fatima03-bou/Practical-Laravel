@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Ajouter une remise</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.discounts.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Nom de la remise</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="type">Type de remise</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="global">Tous les produits</option>
                                <option value="category">Par catégorie</option>
                                <option value="product">Par produit</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3" id="category-select" style="display: none;">
                            <label for="category_id">Catégorie</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group mb-3" id="product-select" style="display: none;">
                            <label for="product_id">Produit</label>
                            <select class="form-control" id="product_id" name="product_id">
                                <option value="">Sélectionner un produit</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="rate">Taux de remise (%)</label>
                            <input type="number" class="form-control" id="rate" name="rate" min="0" max="100" value="{{ old('rate') }}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="start_date">Date de début</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="end_date">Date de fin</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const categorySelect = document.getElementById('category-select');
    const productSelect = document.getElementById('product-select');
    
    typeSelect.addEventListener('change', function() {
        if (this.value === 'category') {
            categorySelect.style.display = 'block';
            productSelect.style.display = 'none';
        } else if (this.value === 'product') {
            categorySelect.style.display = 'none';
            productSelect.style.display = 'block';
        } else {
            categorySelect.style.display = 'none';
            productSelect.style.display = 'none';
        }
    });
    
    // Trigger change event on page load
    typeSelect.dispatchEvent(new Event('change'));
});
</script>
@endsection