@extends('layout.admin')

@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Register User</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="hidden" name="registered_by_admin" value="1">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required onchange="toggleDepartmentField()">
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="hostel">Hostel</option>
                    <option value="library">Library</option>
                    <option value="sports">Sports</option>
                    <option value="computer_lab">Computer Lab</option>
                    <option value="estate">Estate</option>
                    <option value="finance">Finance</option> <!-- Added Finance role -->
                    <option value="hod">HoD</option>
                </select>
            </div>
            <div class="mb-3" id="department-group" style="display:none;">
                <label for="department" class="form-label">Department</label>
                <select name="department" id="department" class="form-select">
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->name }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Register User</button>
        </form>
    </div>
</div>
<script>
function toggleDepartmentField() {
    var role = document.getElementById('role').value;
    var deptGroup = document.getElementById('department-group');
    var deptSelect = document.getElementById('department');
    if(role === 'hod') {
        deptGroup.style.display = 'block';
        deptSelect.setAttribute('required', 'required');
    } else {
        deptGroup.style.display = 'none';
        deptSelect.removeAttribute('required');
        deptSelect.value = '';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    toggleDepartmentField();
});
</script>
@endsection