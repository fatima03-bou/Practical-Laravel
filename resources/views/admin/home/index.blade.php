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
<div class="card">
  <div class="card-header">
    {{__('message.admin_panel_home_page')}}
  </div>
  <div class="card-body">
    <p>Welcome to the Admin Panel, use the sidebar to navigate between the different options.</p>

    <h5 class="mb-3">{{__('message.product_list')}}</h5>

        <a href="{{ route('admin.product.export') }}" class="btn btn-success mb-3">
            <i class="bi bi-download"></i> Export CSV
        </a>

        <form action="{{ route('admin.product.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="file" name="file" class="form-control" required>
                <button type="submit" class="btn btn-primary">Import CSV</button>
            </div>
            <button type="submit" class="btn btn-primary">Import Products</button>
        </form>
        </div>
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Price</th>
          <th>Category</th>
          <th>Quantity</th>
          <th>Supplier</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($viewData['products'] as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->price }} $</td>
          <td>{{ optional($product->categorie)->name ?: 'No categorie' }}</td>
          <td>{{ $product->quantity_store }}</td>
          <td>{{ optional($product->fournisseur)->raison ?: 'No supplier' }}</td>
          <td>
            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger" type="submit">
                <i class="bi-trash"></i> Delete
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
