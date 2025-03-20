@extends('layouts.admin')
@section('title', $viewData["title"])
@section('content')
<div class="card">
  <div class="card-header">
    Admin Panel - Home Page
  </div>
  <div class="card-body">
    <p>Welcome to the Admin Panel, use the sidebar to navigate between the different options.</p>

    <h5 class="mb-3">Products List</h5>
    
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Price</th>
          <th>Category</th>
          <th>Quantity</th>
          <th>Fournisseur</th> 
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($viewData['products'] as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->price }} $</td>
          <td>{{ optional($product->categorie)->name ?: 'No category' }}</td>
          <td>{{ $product->quantity_store }}</td>
          <td>{{ optional($product->fournisseur)->raison ?: 'No fournisseur' }}</td>
          <td>
            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning">Modifier</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>    
  </div>
</div>
@endsection
