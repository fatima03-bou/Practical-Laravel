@extends('layouts.superadmin');
@section('content')
    <div class="card">

        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Admin users</h3>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>Add new admin
                </a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-succes alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (@session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif



            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                            <tr>
                                <td>{{ $admin->id }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    <div>
                                        <a href="{{ route('admin.users.show', $admin->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $admin->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sur you want to delete this admin user ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"class="text-center"> No admin users found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $admins->links() }}
            </div>
        </div>
    </div>
@endsection
