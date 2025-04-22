@extends('layouts.admin')

@section('title', $viewData["title"])

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card shadow-lg">
    <div class="card-header bg-dark text-white">
        Admin Panel - Home Page
    </div>
    <div class="card-body">
        <p>Welcome to the Admin Panel. Use the sidebar to navigate between the different options.</p>

        <h5 class="mb-3">Product List</h5>

        <a href="{{ route('admin.product.export') }}" class="btn btn-success mb-3">
            <i class="bi bi-download"></i> Export CSV
        </a>

        <form action="{{ route('admin.product.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="file" name="file" class="form-control" required>
                <button type="submit" class="btn btn-primary">Import CSV</button>
            </div>
        </form>

        <!-- Filter form -->
        <form method="GET" action="{{ route('admin.home.index') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <select name="categorie_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Filter by Category --</option>
                    @foreach ($viewData['categories'] as $categorie)
                        <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="fournisseur_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Filter by Supplier --</option>
                    @foreach ($viewData['fournisseurs'] as $fournisseur)
                        <option value="{{ $fournisseur->id }}" {{ request('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                            {{ $fournisseur->raison }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <!-- Product Table -->
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Supplier</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData['products'] as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/images/' . $product->image) }}" width="50" height="50" class="rounded-circle" alt="Product Image">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price, 2) }} $</td>
                    <td>{{ optional($product->categorie)->name ?: 'None' }}</td>
                    <td>{{ $product->quantity_store }}</td>
                    <td>{{ optional($product->fournisseur)->raison ?: 'None' }}</td>
                    <td>
                        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>    
    </div>
</div>
@endsection
