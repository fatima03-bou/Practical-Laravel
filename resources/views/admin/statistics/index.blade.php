@extends('layouts.admin')

@section('content')
<h1>{{ $viewData["title"] }}</h1>
<h2>{{ $viewData["subtitle"] }}</h2>

<!-- Sélecteur de période -->
<form method="GET" action="{{ route('admin.statistics.index') }}">
    <label for="period">Choisir la période:</label>
    <select name="period" id="period" onchange="this.form.submit()">
        <option value="day" {{ $viewData['selectedPeriod'] === 'day' ? 'selected' : '' }}>Aujourd'hui</option>
        <option value="month" {{ $viewData['selectedPeriod'] === 'month' ? 'selected' : '' }}>Ce mois-ci</option>
        <option value="year" {{ $viewData['selectedPeriod'] === 'year' ? 'selected' : '' }}>Cette année</option>
        <option value="custom" {{ $viewData['selectedPeriod'] === 'custom' ? 'selected' : '' }}>Période personnalisée</option>
    </select>

    <div id="custom-dates" style="display: {{ $viewData['selectedPeriod'] === 'custom' ? 'block' : 'none' }};">
        <label for="start_date">De :</label>
        <input type="date" name="start_date" value="{{ $viewData['startDate'] }}">
        <label for="end_date">À :</label>
        <input type="date" name="end_date" value="{{ $viewData['endDate'] }}">
        <button type="submit">Filtrer</button>
    </div>
</form>

<h3>Chiffre d'affaires ({{ ucfirst($viewData["selectedPeriod"]) }})</h3>
<p>{{ number_format($viewData["revenue"], 2) }} €</p>

<h3>Bénéfices ({{ ucfirst($viewData["selectedPeriod"]) }})</h3>
<p>{{ number_format($viewData["profit"], 2) }} €</p>

<h3>Revenus par Catégorie</h3>
<table>
    <tr><th>Catégorie</th><th>Revenu (€)</th><th>Bénéfice (€)</th></tr>
    @foreach ($viewData["categorieRevenue"] as $categorie)
        <tr>
            <td>{{ $categorie->name }}</td>
            <td>{{ number_format($categorie->revenue, 2) }} €</td>
            <td>{{ number_format($categorie->profit, 2) }} €</td>
        </tr>
    @endforeach
</table>

<h3>Revenus par Produit</h3>
<table>
    <tr><th>Produit</th><th>Revenu (€)</th><th>Bénéfice (€)</th></tr>
    @foreach ($viewData["productRevenue"] as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ number_format($product->revenue, 2) }} €</td>
            <td>{{ number_format($product->profit, 2) }} €</td>
        </tr>
    @endforeach
</table>

<h3>Revenus par Pays</h3>
<table>
    <tr><th>Pays</th><th>Revenu (€)</th><th>Bénéfice (€)</th></tr>
    @foreach ($viewData["countryRevenue"] as $country)
        <tr>
            <td>{{ $country->country }}</td>
            <td>{{ number_format($country->revenue, 2) }} €</td>
            <td>{{ number_format($country->profit, 2) }} €</td>
        </tr>
    @endforeach
</table>

<!-- Bouton pour télécharger en PDF -->
<a href="{{ route('admin.statistics.pdf', request()->query()) }}" class="btn btn-primary">Télécharger en PDF</a>

@endsection
