@extends('layouts.admin')

@section('content')
<h1 class="mb-4">{{ $viewData["title"] }}</h1>
<h2 class="mb-4 text-muted">{{ $viewData["subtitle"] }}</h2>

<!-- Sélecteur de période -->
<form method="GET" action="{{ route('admin.statistics.index') }}" class="mb-4">
    <label for="period" class="form-label">Choisir la période :</label>
    <select name="period" id="period" class="form-select" onchange="this.form.submit()">
        <option value="day" {{ $viewData['selectedPeriod'] === 'day' ? 'selected' : '' }}>Aujourd'hui</option>
        <option value="month" {{ $viewData['selectedPeriod'] === 'month' ? 'selected' : '' }}>Ce mois-ci</option>
        <option value="year" {{ $viewData['selectedPeriod'] === 'year' ? 'selected' : '' }}>Cette année</option>
        <option value="custom" {{ $viewData['selectedPeriod'] === 'custom' ? 'selected' : '' }}>Période personnalisée</option>
    </select>

    <div id="custom-dates" class="mt-3" style="display: {{ $viewData['selectedPeriod'] === 'custom' ? 'block' : 'none' }};">
        <label for="start_date" class="form-label">De :</label>
        <input type="date" name="start_date" value="{{ $viewData['startDate'] }}" class="form-control mb-2">
        <label for="end_date" class="form-label">À :</label>
        <input type="date" name="end_date" value="{{ $viewData['endDate'] }}" class="form-control mb-2">
        <button type="submit" class="btn btn-primary mt-2">Filtrer</button>
    </div>
</form>

<div class="card mb-4">
    <div class="card-body">
        <h3 class="card-title">Chiffre d'affaires ({{ ucfirst($viewData["selectedPeriod"]) }})</h3>
        <p class="h4">{{ number_format($viewData["revenue"], 2) }} €</p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h3 class="card-title">Bénéfices ({{ ucfirst($viewData["selectedPeriod"]) }})</h3>
        <p class="h4">{{ number_format($viewData["profit"], 2) }} €</p>
    </div>
</div>

<h3 class="mb-3">Revenus par Catégorie</h3>
<table class="table table-bordered table-striped mb-4">
    <thead>
        <tr>
            <th>Catégorie</th>
            <th>Revenu (€)</th>
            <th>Bénéfice (€)</th>
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

<h3 class="mb-3">Revenus par Produit</h3>
<table class="table table-bordered table-striped mb-4">
    <thead>
        <tr>
            <th>Produit</th>
            <th>Revenu (€)</th>
            <th>Bénéfice (€)</th>
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

<h3 class="mb-3">Revenus par Pays</h3>
<table class="table table-bordered table-striped mb-4">
    <thead>
        <tr>
            <th>Pays</th>
            <th>Revenu (€)</th>
            <th>Bénéfice (€)</th>
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

<a href="{{ route('admin.statistics.pdf') }}" class="btn btn-primary mt-4">
    <i class="bi bi-file-earmark-pdf"></i> Télécharger en PDF
</a>
@endsection
