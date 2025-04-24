@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">User Management</h3>
            <a href="{{ url("/superAdmin/create") }}" class="btn btn-light">Create Admin</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-striped">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role == 'super_admin' ? 'bg-danger' : ($user->role == 'admin' ? 'bg-warning' : 'bg-success') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3 d-flex justify-content-center">
                {{ $users->links() }} <!-- Pagination -->
            </div>
        </div>
    </div>
</div>
@endsection
