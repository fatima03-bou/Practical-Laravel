@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">{{ $viewData["title"] }}</h1>
    <h2 class="mb-4 text-muted">{{ $viewData["subtitle"] }}</h2>

    <!-- Period Selector -->
    <div class="card p-4 mb-4 shadow-sm">
        <form method="GET" action="{{ route('admin.statistics.index') }}">
            <label for="period" class="form-label">Select Period:</label>
            <select name="period" id="period" class="form-select mb-3" onchange="this.form.submit()">
                <option value="day" {{ $viewData['selectedPeriod'] === 'day' ? 'selected' : '' }}>Today</option>
                <option value="month" {{ $viewData['selectedPeriod'] === 'month' ? 'selected' : '' }}>This Month</option>
                <option value="year" {{ $viewData['selectedPeriod'] === 'year' ? 'selected' : '' }}>This Year</option>
                <option value="custom" {{ $viewData['selectedPeriod'] === 'custom' ? 'selected' : '' }}>Custom Period</option>
            </select>

            <div id="custom-dates" class="mt-3" style="display: {{ $viewData['selectedPeriod'] === 'custom' ? 'block' : 'none' }};">
                <label for="start_date" class="form-label">From:</label>
                <input type="date" name="start_date" value="{{ $viewData['startDate'] }}" class="form-control mb-2">
                <label for="end_date" class="form-label">To:</label>
                <input type="date" name="end_date" value="{{ $viewData['endDate'] }}" class="form-control mb-2">
                <button type="submit" class="btn btn-primary mt-2">Filter</button>
            </div>
        </form>
    </div>

    <!-- Revenue and Profit Summary -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h3 class="card-title">Revenue ({{ ucfirst($viewData["selectedPeriod"]) }})</h3>
                    <p class="h4 text-success">{{ number_format($viewData["revenue"], 2) }} €</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h3 class="card-title">Profit ({{ ucfirst($viewData["selectedPeriod"]) }})</h3>
                    <p class="h4 text-primary">{{ number_format($viewData["profit"], 2) }} €</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue by Category -->
    <div class="card p-4 mb-4 shadow-sm">
        <h3 class="mb-3">Revenue by Category</h3>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Category</th>
                    <th>Revenue (€)</th>
                    <th>Profit (€)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData["categorieRevenue"] as $categorie)
                <tr>
                    <td>{{ $categorie->name }}</td>
                    <td>{{ number_format($categorie->revenue, 2) }} €</td>
                    <td>{{ number_format($categorie->profit, 2) }} €</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Revenue by Product -->
    <div class="card p-4 mb-4 shadow-sm">
        <h3 class="mb-3">Revenue by Product</h3>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Revenue (€)</th>
                    <th>Profit (€)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData["productRevenue"] as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->revenue, 2) }} €</td>
                    <td>{{ number_format($product->profit, 2) }} €</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Revenue by Country -->
    <div class="card p-4 mb-4 shadow-sm">
        <h3 class="mb-3">Revenue by Country</h3>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Country</th>
                    <th>Revenue (€)</th>
                    <th>Profit (€)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData["countryRevenue"] as $country)
                <tr>
                    <td>{{ $country->country }}</td>
                    <td>{{ number_format($country->revenue, 2) }} €</td>
                    <td>{{ number_format($country->profit, 2) }} €</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Download PDF -->
    <div class="text-end">
        <a href="{{ route('admin.statistics.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Download PDF
        </a>
    </div>
</div>
@endsection
