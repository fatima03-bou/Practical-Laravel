@extends('layouts.admin')
@section('title', $viewData["title"])
@section('content')
<div class="container">
    <h1 class="mb-4">{{ $viewData['title'] }}</h1>

    <!-- Date Range Form -->
    <form method="GET" action="{{ route('statistics.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-5">
                @php
                    use Carbon\Carbon;
                @endphp
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date', Carbon::today()->toDateString()) }}">
            </div>
            <div class="col-md-5">
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date', Carbon::tomorrow()->toDateString()) }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </div>
        </div>
    </form>
    <!-- Chiffre d'affaires (Revenue) -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    Chiffre d'affaires
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li><strong>Aujourd'hui:</strong> ${{ $viewData['revenueToday'] }}</li>
                        <li><strong>Ce mois-ci:</strong> ${{ $viewData['revenueMonth'] }}</li>
                        <li><strong>Cette année:</strong> ${{ $viewData['revenueYear'] }}</li>
                        {{-- <li><strong>Période:</strong> ${{ $viewData['revenuePeriod'] }}</li> --}}
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    Bénéfice
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li><strong>Aujourd'hui:</strong> ${{ $viewData['profitToday'] }}</li>
                        <li><strong>Ce mois-ci:</strong> ${{ $viewData['profitMonth'] }}</li>
                        <li><strong>Cette année:</strong> ${{ $viewData['profitYear'] }}</li>
                        {{-- <li><strong>Période:</strong> ${{ $viewData['profitPeriod'] }}</li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Chiffre d'affaires par Produit -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            Chiffre d'affaires par Produit
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered m-0">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Chiffre d'affaires</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($viewData['revenueByProduct'] as $data)
                        <tr>
                            <td>{{ $data->produit }}</td>
                            <td>${{ $data->revenue }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chiffre d'affaires par Catégorie -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            Chiffre d'affaires par Catégorie
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered m-0">
                <thead>
                    <tr>
                        <th>Catégorie</th>
                        <th>Chiffre d'affaires</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($viewData['revenueByCategory'] as $data)
                        <tr>
                            <td>{{ $data->categorie }}</td>
                            <td>${{ $data->revenue }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chiffre d'affaires par Pays -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            Chiffre d'affaires par Pays
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered m-0">
                <thead>
                    <tr>
                        <th>Pays</th>
                        <th>Chiffre d'affaires</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($viewData['revenueByCountry'] as $data)
                        <tr>
                            <td>{{ $data->pays }}</td>
                            <td>${{ $data->revenue }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bénéfice par Produit -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            Bénéfice par Produit
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered m-0">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Bénéfice</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($viewData['profitByProduct'] as $data)
                        <tr>
                            <td>{{ $data->produit }}</td>
                            <td>${{ $data->profit }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bénéfice par Catégorie -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            Bénéfice par Catégorie
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered m-0">
                <thead>
                    <tr>
                        <th>Catégorie</th>
                        <th>Bénéfice</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($viewData['profitByCategory'] as $data)
                        <tr>
                            <td>{{ $data->categorie }}</td>
                            <td>${{ $data->profit }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bénéfice par Pays -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            Bénéfice par Pays
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered m-0">
                <thead>
                    <tr>
                        <th>Pays</th>
                        <th>Bénéfice</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($viewData['profitByCountry'] as $data)
                        <tr>
                            <td>{{ $data->pays }}</td>
                            <td>${{ $data->profit }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bouton pour exporter en PDF -->
    <div class="text-center my-4">
        <a href="{{ route('statistics.exportPdf', request()->all() ) }}" class="btn btn-danger">Télécharger le rapport PDF</a>
    </div>
</div>
@endsection
