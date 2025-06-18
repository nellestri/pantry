@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Create New User</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Users
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role *</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff Member</option>
                                <option value="volunteer" {{ old('role') == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password *</label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active User
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Role Permissions</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong class="text-danger">Administrator</strong>
                    <ul class="list-unstyled mt-2">
                        <li><i class="bi bi-check text-success"></i> Full system access</li>
                        <li><i class="bi bi-check text-success"></i> User management</li>
                        <li><i class="bi bi-check text-success"></i> Admin panel access</li>
                        <li><i class="bi bi-check text-success"></i> Reports & analytics</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <strong class="text-primary">Staff Member</strong>
                    <ul class="list-unstyled mt-2">
                        <li><i class="bi bi-check text-success"></i> Manage inventory</li>
                        <li><i class="bi bi-check text-success"></i> Record donations</li>
                        <li><i class="bi bi-check text-success"></i> View reports</li>
                        <li><i class="bi bi-x text-danger"></i> User management</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <strong class="text-success">Volunteer</strong>
                    <ul class="list-unstyled mt-2">
                        <li><i class="bi bi-check text-success"></i> View inventory</li>
                        <li><i class="bi bi-check text-success"></i> Basic operations</li>
                        <li><i class="bi bi-x text-danger"></i> Admin functions</li>
                        <li><i class="bi bi-x text-danger"></i> User management</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
