@extends('layouts.admin')
@section('title', $viewData["title"])

@section('content')
<!-- FontAwesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
<!-- Custom CSS for the select width -->
<style>
  .form-select, .select2-container {
    width: 100% !important;
  }
  .select2-selection {
    height: 38px !important;
    padding: 5px !important;
  }
  .select2-container--default .select2-selection--single {
    border: 1px solid #ced4da !important;
  }
</style>

<div class="card">
  <div class="card-header">
    Admin Panel - Orders
  </div>
  @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif

  <div class="card-body">
    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">User</th>
          <th scope="col">Total Price</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($viewData["orders"] as $order)
        <tr>
          <th scope="row">{{ $order->id }}</th>
          <td>{{ $order->user->name }}</td>
          <td>${{ $order->total }}</td>
          <td>
            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="w-100">
              @csrf
              @method('PUT')
              <select name="status" class="form-select select2" onchange="this.form.submit()">
                <option value="Packed" {{ $order->status == 'Packed' ? 'selected' : '' }} data-icon="fas fa-box">Packed</option>
                <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }} data-icon="fas fa-shipping-fast">Shipped</option>
                <option value="In Transit" {{ $order->status == 'In Transit' ? 'selected' : '' }} data-icon="fas fa-route">In Transit</option>
                <option value="Received" {{ $order->status == 'Received' ? 'selected' : '' }} data-icon="fas fa-check-circle">Received</option>
                <option value="Returned" {{ $order->status == 'Returned' ? 'selected' : '' }} data-icon="fas fa-undo-alt">Returned</option>
                <option value="Closed" {{ $order->status == 'Closed' ? 'selected' : '' }} data-icon="fas fa-times-circle">Closed</option>
              </select>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    // Initialize select2 with icons
    $('.select2').select2({
      width: '100%',
      dropdownAutoWidth: true,
      templateResult: function(state) {
        if (!state.id) { return state.text; }
        var $state = $('<span><i class="' + $(state.element).data('icon') + '"></i> ' + state.text + '</span>');
        return $state;
      },
      templateSelection: function(state) {
        if (!state.id) { return state.text; }
        var $state = $('<span><i class="' + $(state.element).data('icon') + '"></i> ' + state.text + '</span>');
        return $state;
      }
    });
  });
</script>
@endsection