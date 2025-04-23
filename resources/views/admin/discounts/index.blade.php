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
                                <th>{{__('message.name')}}</th>
                                <th>{{__('message.type')}}</th>
                                <th>{{__('message.rate')}}</th>
                                <th>{{__('message.period')}}</th>
                                <th>{{__('message.apply_in')}}</th>
                                <th>{{__('message.statut')}}</th>
                                <th>{{__('message.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($discounts as $discount)
                            <tr>
                                <td>{{ $discount->name }}</td>
                                <td>
                                    @if($discount->type == 'global')
                                    {{__('message.all_products')}}
                                    @elseif($discount->type == 'categorie')
                                    {{__('message.cat')}}
                                    @else
                                    {{__('message.products')}}
                                    @endif
                                </td>
                                <td>{{ $discount->rate }}%</td>
                                <td>
                                    Du {{ $discount->start_date->format('d/m/Y') }}
                                    au {{ $discount->end_date->format('d/m/Y') }}
                                </td>
                                <td>
                                    @if($discount->type == 'global')
                                    {{__('message.all_products')}}
                                    @elseif($discount->type == 'categorie')
                                        {{ $discount->categorie->name ?? 'N/A' }}
                                    @else
                                        {{ $discount->product->name ?? 'N/A' }}
                                    @endif
                                </td>
                                <td>
                                    @if($discount->isActive())
                                        <span class="badge bg-success">{{__('message.actif')}}</span>
                                    @else
                                        <span class="badge bg-danger">{{__('message.inactif')}}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.discounts.edit', $discount) }}" class="btn btn-sm btn-primary">{{__('message.update')}}</a>
                                    <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette remise?')">{{__('message.delete')}}</button>
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
