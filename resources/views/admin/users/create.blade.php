@extends('layouts.superadmin');

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3>{{__('message.create_admin_user')}}</h3>
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
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{__('message.name')}}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                        required />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{__('message.email')}}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                        required />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{__('message.password')}}</label>
                    <input type="password" class="form-control" id="password" name="password" required />
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{__('message.confirm_password')}}</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        required />
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">{{__('message.create')}}</button>
                </div>

            </form>
        </div>
    </div>
@endsection
