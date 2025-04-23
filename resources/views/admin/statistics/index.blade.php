@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div>
            <h1 class="fw-bold">{{ $viewData["title"] }}</h1>
            <h2 class="text-muted">{{ $viewData["subtitle"] }}</h2>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.statistics.pdf') }}" class="btn btn-danger btn-lg">
                <i class="bi bi-file-earmark-pdf"></i> Télécharger en PDF
            </a>
        </div>
    </div>

    <!-- Period Selector -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.statistics.index') }}">
                <div class="mb-3">
                    <label for="period" class="form-label">Choisir la période :</label>
                    <select name="period" id="period" class="form-select" onchange="this.form.submit()">
                        <option value="day" {{ $viewData['selectedPeriod'] === 'day' ? 'selected' : '' }}>Aujourd'hui</option>
                        <option value="month" {{ $viewData['selectedPeriod'] === 'month' ? 'selected' : '' }}>Ce mois-ci</option>
                        <option value="year" {{ $viewData['selectedPeriod'] === 'year' ? 'selected' : '' }}>Cette année</option>
                        <option value="custom" {{ $viewData['selectedPeriod'] === 'custom' ? 'selected' : '' }}>Période personnalisée</option>
                    </select>
                </div>

                <div id="custom-dates" class="row g-3 {{ $viewData['selectedPeriod'] === 'custom' ? '' : 'd-none' }}">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">De :</label>
                        <input type="date" name="start_date" value="{{ $viewData['startDate'] }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">À :</label>
                        <input type="date" name="end_date" value="{{ $viewData['endDate'] }}" class="form-control">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-2">Filtrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Revenue & Profit Summary -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">Chiffre d'affaires ({{ ucfirst($viewData["selectedPeriod"]) }})</h3>
                    <p class="h4 text-success">{{ number_format($viewData["revenue"], 2) }} €</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">Bénéfices ({{ ucfirst($viewData["selectedPeriod"]) }})</h3>
                    <p class="h4 text-success">{{ number_format($viewData["profit"], 2) }} €</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables -->
    @php
        $tables = [
            'Revenus par Catégorie' => $viewData["categorieRevenue"],
            'Revenus par Produit' => $viewData["productRevenue"],
            'Revenus par Pays' => $viewData["countryRevenue"]
        ];
    @endphp

    @foreach ($tables as $title => $data)
        <div class="mb-4">
            <h3 class="mb-3">{{ $title }}</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>{{ $title === 'Revenus par Pays' ? 'Pays' : ($title === 'Revenus par Produit' ? 'Produit' : 'Catégorie') }}</th>
                            <th>Revenu (€)</th>
                            <th>Bénéfice (€)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->name ?? $item->country }}</td>
                            <td>{{ number_format($item->revenue, 2) }} €</td>
                            <td>{{ number_format($item->profit, 2) }} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>

<script>
    document.getElementById("period").addEventListener("change", function () {
        const customDates = document.getElementById("custom-dates");
        customDates.classList.toggle("d-none", this.value !== "custom");
    });
</script>
@endsection
