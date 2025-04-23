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

    <!-- Export / Import Buttons -->
    <div class="mb-3">
      <a href="{{ route('admin.product.export') }}" class="btn btn-success">
        {{__('message.export_prod')}}
      </a>
      <button class="btn btn-primary" data-toggle="modal" data-target="#importModal">
        {{__('message.import_prod')}}
      </button>
    </div>

    <!-- Modal for Import -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="importModalLabel">{{__('message.import_prod')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('admin.product.import') }}" method="POST" enctype="multipart/form-data">

            @csrf
            <div class="form-group">
                <label for="csv_file">{{__('message.chiise_file')}}</label>
                <input type="file" class="form-control" name="csv_file" required>
            </div>
            <button type="submit" class="btn btn-primary">{{__('message.import_prod')}}</button>
        </form>
        </div>
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>{{__('message.name')}}</th>
          <th>{{__('message.price')}}</th>
          <th>{{__('message.cat')}}</th>
          <th>{{__('message.quantity')}}</th>
          <th>{{__('message.fourni')}}</th>
          <th>{{__('message.actions')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($viewData['products'] as $product)
        <tr>
          <td>{{ $product->id}}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->price }} $</td>
          <td>{{ optional($product->categorie)->name ?: 'No categorie' }}</td>
          <td>{{ $product->quantity_store }}</td>
          <td>{{ optional($product->fournisseur)->raison ?: 'No supplier' }}</td>
          <td>
            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning">{{__('message.edit')}}</a>
            <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger" type="submit">
                <i class="bi-trash"></i> D{{__('message.save')}}{{__('message.delete')}}
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
