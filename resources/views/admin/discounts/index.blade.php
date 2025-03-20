@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Gestion des remises</h2>
                    <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">Ajouter une remise</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Taux</th>
                                <th>Période</th>
                                <th>Appliqué à</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($discounts as $discount)
                            <tr>
                                <td>{{ $discount->name }}</td>
                                <td>
                                    @if($discount->type == 'global')
                                        Tous les produits
                                    @elseif($discount->type == 'category')
                                        Catégorie
                                    @else
                                        Produit
                                    @endif
                                </td>
                                <td>{{ $discount->rate }}%</td>
                                <td>
                                    Du {{ $discount->start_date->format('d/m/Y') }}
                                    au {{ $discount->end_date->format('d/m/Y') }}
                                </td>
                                <td>
                                    @if($discount->type == 'global')
                                        Tous les produits
                                    @elseif($discount->type == 'category')
                                        {{ $discount->category->name ?? 'N/A' }}
                                    @else
                                        {{ $discount->product->name ?? 'N/A' }}
                                    @endif
                                </td>
                                <td>
                                    @if($discount->isActive())
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-danger">Inactif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.discounts.edit', $discount) }}" class="btn btn-sm btn-primary">Modifier</a>
                                    <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette remise?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection