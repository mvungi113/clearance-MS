@extends('layout.admin')

@section('content')
@php
    if (!auth()->user() || auth()->user()->role !== 'admin') {
        abort(404);
    }
@endphp
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex align-items-center">
        <i class="bi bi-person-circle text-info fs-3 me-2"></i>
        <h5 class="mb-0">My Profile</h5>
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-4"><i class="bi bi-person-fill me-1"></i>First Name</dt>
            <dd class="col-sm-8">{{ auth()->user()->first_name }}</dd>

            <dt class="col-sm-4"><i class="bi bi-person-fill me-1"></i>Last Name</dt>
            <dd class="col-sm-8">{{ auth()->user()->last_name }}</dd>

            <dt class="col-sm-4"><i class="bi bi-envelope-fill me-1"></i>Email</dt>
            <dd class="col-sm-8">{{ auth()->user()->email }}</dd>

            <dt class="col-sm-4"><i class="bi bi-person-badge-fill me-1"></i>Role</dt>
            <dd class="col-sm-8">{{ ucfirst(auth()->user()->role) }}</dd>
        </dl>

        <hr class="my-4">
        <h6 class="mb-3"><i class="bi bi-key me-1"></i>Update Password</h6>
        @if(session('password_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('password_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i> {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form method="POST" action="{{ route('student.profile.password') }}">
            @csrf
            <div class="mb-2">
                <label for="current_password" class="form-label">Current Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="current_password" id="current_password" class="form-control" required autocomplete="current-password">
                </div>
            </div>
            <div class="mb-2">
                <label for="new_password" class="form-label">New Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                    <input type="password" name="new_password" id="new_password" class="form-control" required autocomplete="new-password">
                </div>
            </div>
            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required autocomplete="new-password">
                </div>
            </div>
            <button type="submit" class="btn btn-info btn-sm text-white">
                <i class="bi bi-arrow-repeat me-1"></i> Update Password
            </button>
        </form>
    </div>
</div>
@endsection