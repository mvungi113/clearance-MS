@extends('layout.admin')

@section('content')
    <h2 class="mb-3">Welcome, {{ auth()->user()->first_name ?? 'Admin' }}!</h2>
    <p class="mb-4">This is your admin dashboard. Use the shortcuts below to manage the system.</p>

    <div class="row mt-4">
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-person-plus display-4 text-primary mb-2"></i>
                    <h5 class="card-title">Register Users</h5>
                    <p class="card-text">Add new admins, HoDs, or department staff.</p>
                    <a href="{{ route('admin.register.users') }}" class="btn btn-primary btn-sm">Register Admin/Department</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-people display-4 text-success mb-2"></i>
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">View, edit, or remove users from the system.</p>
                    <a href="{{ route('admin.manage.users') }}" class="btn btn-success btn-sm">Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-journal-plus display-4 text-info mb-2"></i>
                    <h5 class="card-title">Register Department/Course</h5>
                    <p class="card-text">Add new departments or courses for clearance.</p>
                    <a href="{{ route('admin.register.course') }}" class="btn btn-info btn-sm text-white">Register Department/Course</a>
                </div>
            </div>
        </div>
        <!-- Example: Add more cards as needed -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart-line display-4 text-warning mb-2"></i>
                    <h5 class="card-title">Reports</h5>
                    <p class="card-text">View clearance statistics and reports.</p>
                    <a href="#" class="btn btn-warning btn-sm text-white disabled">Coming Soon</a>
                </div>
            </div>
        </div>
    </div>
@endsection