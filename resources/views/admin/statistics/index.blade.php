@extends('layouts.admin')

@section('content')
<h1>{{ $viewData["title"] }}</h1>
<h2>{{ $viewData["subtitle"] }}</h2>

<!-- Sélecteur de période -->
<form method="GET" action="{{ route('admin.statistics.index') }}">
    <label for="period">{{__('message.choose_per')}}:</label>
    <select name="period" id="period" onchange="this.form.submit()">
        <option value="day" {{ $viewData['selectedPeriod'] === 'day' ? 'selected' : '' }}>{{__('message.today')}}</option>
        <option value="month" {{ $viewData['selectedPeriod'] === 'month' ? 'selected' : '' }}>{{__('message.this_month')}}</option>
        <option value="year" {{ $viewData['selectedPeriod'] === 'year' ? 'selected' : '' }}>{{__('message.this_year')}}</option>
        <option value="custom" {{ $viewData['selectedPeriod'] === 'custom' ? 'selected' : '' }}>{{__('message.custom_per')}}</option>
    </select>

    <div id="custom-dates" style="display: {{ $viewData['selectedPeriod'] === 'custom' ? 'block' : 'none' }};">
        <label for="start_date">{{__('message.de')}} :</label>
        <input type="date" name="start_date" value="{{ $viewData['startDate'] }}">
        <label for="end_date">{{__('message.à')}} :</label>
        <input type="date" name="end_date" value="{{ $viewData['endDate'] }}">
        <button type="submit">{{__('message.filter')}}</button>
    </div>
</form>

<h3>{{__('message.chiffre_aff')}} ({{ ucfirst($viewData["selectedPeriod"]) }})</h3>
<p>{{ number_format($viewData["revenue"], 2) }} €</p>

<h3>Bénéfices ({{ ucfirst($viewData["selectedPeriod"]) }})</h3>
<p>{{ number_format($viewData["profit"], 2) }} €</p>

<h3>{{__('message.revenu_by_cat')}}</h3>
<table>
    <tr><th>{{__('message.cat')}}</th><th>{{__('message.chiffre_aff')}} (€)</th><th>{{__('message.benifice')}} (€)</th></tr>
    @foreach ($viewData["categorieRevenue"] as $categorie)
        <tr>
            <td>{{ $categorie->name }}</td>
            <td>{{ number_format($categorie->revenue, 2) }} €</td>
            <td>{{ number_format($categorie->profit, 2) }} €</td>
        </tr>
    @endforeach
</table>

<h3>{{__('message.revenu_by_prod')}}</h3>
<table>
    <tr><th>{{__('message.prod')}}</th><th>{{__('message.chiffre_aff')}} (€)</th><th>{{__('message.benefice')}} (€)</th></tr>
    @foreach ($viewData["productRevenue"] as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ number_format($product->revenue, 2) }} €</td>
            <td>{{ number_format($product->profit, 2) }} €</td>
        </tr>
    @endforeach
</table>

<h3>{{__('message.revenu_by_country')}}</h3>
<table>
    <tr><th>{{__('message.pays')}}</th><th>{{__('message.chiffre_aff')}} (€)</th><th>{{__('message.benefice')}} (€)</th></tr>
    @foreach ($viewData["countryRevenue"] as $country)
        <tr>
            <td>{{ $country->country }}</td>
            <td>{{ number_format($country->revenue, 2) }} €</td>
            <td>{{ number_format($country->profit, 2) }} €</td>
        </tr>
    @endforeach
</table>

<a href="{{ route('admin.statistics.pdf') }}" class="btn btn-primary">
    <i class="bi bi-file-earmark-pdf"></i>{{__('message.down_pdf')}}
</a>


@endsection
