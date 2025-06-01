@extends('layout.student')

@section('content')
@php
    if (!auth()->user() || auth()->user()->role !== 'student') {
        abort(404);
    }
@endphp
    <div class="mb-4">
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="bi bi-person-circle fs-2 me-3"></i>
            <div>
                <h4 class="alert-heading mb-1">
                    Welcome Back, {{ auth()->user()->first_name ?? auth()->user()->name ?? 'Student' }}!
                </h4>
                <p class="mb-0">This is your student dashboard.</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-journal-plus text-primary fs-1 mb-2"></i>
                    <h5 class="card-title">Clearance Requests</h5>
                    <p class="card-text">Submit a new clearance request or view your pending requests.</p>
                    <a href="{{ route('student.clearance.request.form') }}" class="btn btn-primary btn-sm">Request Clearance</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-clipboard-check text-success fs-1 mb-2"></i>
                    <h5 class="card-title">My Clearance Status</h5>
                    <p class="card-text">Track the status of your clearance requests in real time.</p>
                    <a href="{{ route('student.clearance.status') }}" class="btn btn-success btn-sm text-white">View Status</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle text-info fs-1 mb-2"></i>
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text">Update your personal information and change your password.</p>
                    <a href="{{ route('student.profile') }}" class="btn btn-info btn-sm text-white">View Profile</a>
                </div>
            </div>
        </div>
    </div>
@endsection