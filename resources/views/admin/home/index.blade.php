@extends('layouts.admin')

@section('title', $viewData["title"])

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-dark text-white">
        Admin Panel - Home Page
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.product.export') }}" class="btn btn-primary">
                <i class="bi bi-download"></i> Export CSV
            </a>
            <form action="{{ route('admin.product.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                @csrf
                <div class="input-group">
                    <input type="file" name="file" class="form-control" required>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload"></i> Import CSV
                    </button>
                </div>
            </form>
        </div>
        <h5 class="mb-3">Product List</h5>
        
        <!-- Filter Form -->
        <!-- Existing filter form code goes here -->

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
                    <td>{{ optional($product->fournisseur)->raison_social ?: 'None' }}</td>
                    <td>
                        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
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

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $viewData['products']->links() }}
        </div>
    </div>
</div>

<!-- Confirmation Script -->
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this product?');
    }
</script>
@endsection
