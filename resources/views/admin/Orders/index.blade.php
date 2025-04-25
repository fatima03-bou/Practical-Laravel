@extends('layouts.admin')
@section('title', $viewData["title"])

@section('content')
<!-- FontAwesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- Custom CSS for the layout -->
<style>
  /* Custom card layout */
  .order-card {
    border: 1px solid #ddd;
    border-radius: 12px;
    margin-bottom: 20px;
    padding: 20px;
    background-color: #fafafa;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .order-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  }

  .order-card-header {
    font-weight: bold;
    font-size: 22px;
    color: #333;
  }

  .order-card-body {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
  }

  .order-info {
    font-size: 16px;
    color: #555;
    flex-grow: 1;
  }

  .order-actions {
    width: 220px;
    text-align: right;
  }

  /* Gray Select Dropdown Style */
  .select2-container {
    width: 100% !important;
  }

  .select2-selection {
    height: 42px !important;
    padding: 8px !important;
    border-radius: 8px;
    border: 1px solid #ccc;
    background-color: #e9ecef;
    font-size: 14px;
    color: #333;
    box-shadow: none !important;
    transition: border-color 0.3s ease;
  }

  .select2-container--default .select2-selection--single {
    border-color: #ccc !important;
  }

  .select2-container--default .select2-selection--single:hover {
    border-color: #bbb !important;
  }

  .select2-container .select2-selection__rendered {
    display: flex;
    align-items: center;
    color: #333; /* Black text for options */
  }

  .select2-container .select2-selection__arrow {
    top: 50%;
    transform: translateY(-50%);
  }

  .select2-results__option {
    color: black !important; /* Ensuring black color for the options */
  }

  .select2-results__option[aria-selected="true"] {
    background-color: #007bff;
    color: white !important;
  }

  /* Button style */
  .btn-update {
    padding: 12px 20px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s;
    text-align: center;
    display: block;
  }

  .btn-update:hover {
    background-color: #218838;
  }

  /* Alert Style */
  .alert-success {
    background-color: #d4edda;
    color: #155724;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
  }

  .icon {
    margin-right: 8px;
    font-size: 18px;
    color: #007bff;
  }
</style>

<div class="card shadow-sm">
  <div class="card-header bg-primary text-white rounded-top">
    <h5 class="m-0">Admin Panel - Orders</h5>
  </div>
  
  @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif

  <div class="card-body">
    @foreach ($viewData["orders"] as $order)
      <div class="order-card">
        <div class="order-card-header">
          Order #{{ $order->id }}
        </div>
        <div class="order-card-body">
          <div class="order-info">
            <p><strong>User:</strong> {{ $order->user->name }}</p>
            <p><strong>Total:</strong> ${{ $order->total }}</p>
          </div>
          <div class="order-actions">
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
          </div>
        </div>
      </div>
    @endforeach
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
