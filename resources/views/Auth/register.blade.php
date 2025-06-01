@extends('layout.app')

@section('content')
<div class="container mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Student Registration</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                    <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                        @csrf
                        <input type="hidden" name="role" value="student">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control no-outline" required pattern="^[A-Za-z]{2,}$" title="Only letters, at least 2 characters">
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control no-outline" required pattern="^[A-Za-z]{2,}$" title="Only letters, at least 2 characters">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control no-outline" required>
                        </div>
                        <div class="mb-3">
                            <label for="course" class="form-label">Course</label>
                            <select name="course" id="course" class="form-select no-outline" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{$course->name }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select name="department" id="department" class="form-select no-outline" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->name }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control no-outline" required pattern="^\d{10}$" title="Enter a valid 10-digit phone number">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control no-outline" required minlength="6">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control no-outline" required minlength="6">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Register</button>
                    </form>
                    <div class="mt-3 text-center">
                        Already have an account?
                        <a href="{{ route('login') }}">Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .no-outline:focus, .no-outline:active {
        outline: none !important;
        box-shadow: none !important;
        border-color: #ced4da !important;
    }
</style>
<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    // Password match check
    const pass = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    if (pass !== confirm) {
        alert('Passwords do not match!');
        e.preventDefault();
        return false;
    }
});
</script>
@endsection