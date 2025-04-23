@extends('layouts.superadmin');
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title"> {{__('message.edit_admin_user')}} : {{ $admin->name }}</h3>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>{{__('message.back_to_list')}}
                </a>
            </div>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.users.update', $admin->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">{{__('message.name')}}</label>
                    <input type="text"class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $admin->name) }}" required />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{__('message.email')}}</label>
                    <input type="email" class="form-control @error('name') is-invalid @enderror" id="email"
                        name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $admin->email) }}" required />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{__('message.new_pass')}}</label>
                    <input type="password" class="form-control" id="password"
                        class="form-control @error('password') is-invalid @enderror" name="password" required />
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{__('message.confirm_password')}}</label>
                    <input type="password" class="form-control" id="password_confirmation" class="form-control"
                        name="password_confirmation" required />
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">{{__('message.update')}}</button>
                </div>


            </form>
        </div>
    </div>
@endsection
