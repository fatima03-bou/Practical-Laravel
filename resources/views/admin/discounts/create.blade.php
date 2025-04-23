@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>{{__('message.add_remise')}}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.discounts.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{__('message.name_remise')}}</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="type">{{__('message.type_remise')}}</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="global">{{__('message.all_products')}}</option>
                                <option value="categorie">{{__('message.by_cat')}}</option>
                                <option value="product">{{__('message.by_prod')}}</option>
                            </select>
                        </div>

                        <div class="form-group mb-3" id="categorie-select" style="display: none;">
                            <label for="categorie_id">{{__('message.cat')}}</label>
                            <select class="form-control" id="categorie_id" name="categorie_id">
                                <option value="">{{__('message.select_cat')}}</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3" id="product-select" style="display: none;">
                            <label for="product_id">{{__('message.products')}}</label>
                            <select class="form-control" id="product_id" name="product_id">
                                <option value="">{{__('message.select_prod')}}</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="rate">{{__('message.remise_rate')}}</label>
                            <input type="number" class="form-control" id="rate" name="rate" min="0" max="100" value="{{ old('rate') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="start_date">{{__('message.start_date')}}</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="end_date">{{__('message.end_date')}}/label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">{{__('message.save')}}</button>
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
    const categorieSelect = document.getElementById('categorie-select');
    const productSelect = document.getElementById('product-select');

    typeSelect.addEventListener('change', function() {
        if (this.value === 'categorie') {
            categorieSelect.style.display = 'block';
            productSelect.style.display = 'none';
        } else if (this.value === 'product') {
            categorieSelect.style.display = 'none';
            productSelect.style.display = 'block';
        } else {
            categorieSelect.style.display = 'none';
            productSelect.style.display = 'none';
        }
    });

    // Trigger change event on page load
    typeSelect.dispatchEvent(new Event('change'));
});
</script>
@endsection
