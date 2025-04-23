@extends('layouts.superadmin');
@section('content')


    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-item-center ">
                <h3 class="card-title">{{__('message.adminuser_details')}}</h3>
                <div>
                    <a href="{{ route('admin.users.edit', $admin->id) }}">
                        <i class="fas fa-edit"></i> {{__('message.edit')}}
                    </a>
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fas fa-left"></i> {{__('message.back_to_list')}}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 30%">Id</th>
                            <td>{{ $admin->id }}</td>
                        </tr>
                        <tr>
                            <th>{{__('message.name')}}</th>
                            <td>{{ $admin->name }}</td>
                        </tr>
                        <tr>
                            <th>{{__('message.email')}}</th>
                            <td>{{ $admin->email }}</td>
                        </tr>
                        <tr>
                            <th>{{__('message.role')}}</th>
                            <td>
                                <span class="badge bg-success">{{__('message.administr')}}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>{{__('message.last_updated')}}</th>
                            <td>{{ $admin->updated_at->format('F d, Y h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
            <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this admin user?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> {{__('message.delete')}}
                </button>
            </form>
        </div>

        </div>
    </div>
    @endsection
