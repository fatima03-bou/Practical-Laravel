@extends('layouts.admin')

@section('content')
<h1 class="mb-4">{{ $viewData["title"] }}</h1>
<h2 class="mb-4 text-muted">{{ $viewData["subtitle"] }}</h2>

<!-- Sélecteur de période -->
<form method="GET" action="{{ route('admin.statistics.index') }}">
    <label for="period">{{__('message.choose_per')}}:</label>
    <select name="period" id="period" onchange="this.form.submit()">
        <option value="day" {{ $viewData['selectedPeriod'] === 'day' ? 'selected' : '' }}>{{__('message.today')}}</option>
        <option value="month" {{ $viewData['selectedPeriod'] === 'month' ? 'selected' : '' }}>{{__('message.this_month')}}</option>
        <option value="year" {{ $viewData['selectedPeriod'] === 'year' ? 'selected' : '' }}>{{__('message.this_year')}}</option>
        <option value="custom" {{ $viewData['selectedPeriod'] === 'custom' ? 'selected' : '' }}>{{__('message.custom_per')}}</option>


    <div id="custom-dates" class="mt-3"  style="display: {{ $viewData['selectedPeriod'] === 'custom' ? 'block' : 'none' }};">
        <label for="start_date" class="form-label">{{__('message.de')}} :</label>
        <input type="date" name="start_date" value="{{ $viewData['startDate'] }}" class="form-control mb-2">
        <label for="end_date" class="form-label">{{__('message.à')}} :</label>
        <input type="date" name="end_date" value="{{ $viewData['endDate'] }}" class="form-control mb-2">
        <button type="submit" class="btn btn-primary mt-2">{{__('message.filter')}}</button>

</form>

<div class="card mb-4">
    <div class="card-body">
        <h3 class="card-title">{{__('message.chiffre_aff')}} ({{ ucfirst($viewData["selectedPeriod"]) }})</h3>
        <p class="h4">{{ number_format($viewData["revenue"], 2) }} €</p>
    </div>
</div>

<h3 class="mb-3">{{__('message.revenu_by_cat')}}</h3>
<table class="table table-bordered table-striped mb-4">
    <thead>
        <tr>
            <th>{{__('message.cat')}}</th>
            <th>{{__('message.price')}} (€)</th>
            <th>{{__('message.benefice')}}</th>
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

<h3 class="mb-3">{{__('message.revenu_by_prod')}}</h3>
<table class="table table-bordered table-striped mb-4">
    <thead>
        <tr>
            <th>{{__('message.prod')}}</th>
            <th>{{__('message.chiffre_aff')}} (€)</th>
            <th>{{__('message.benifice')}}</th>
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

<h3 class="mb-3">{{__('message.revenu_by_country')}}</h3>
<table class="table table-bordered table-striped mb-4">
    <thead>
        <tr>
            <th>{{__('message.pays')}}</th>
            <th>{{__('message.chiffre_aff')}} (€)</th>
            <th>{{__('message.benifice')}} (€)</th>
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
    <i class="bi bi-file-earmark-pdf"></i>{{__('message.down_pdf')}}
</a>
@endsection
