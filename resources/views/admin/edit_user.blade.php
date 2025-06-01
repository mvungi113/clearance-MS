@extends('layout.admin')

@section('content')
<div class="container mt-4">
    <h3>Edit User</h3>
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required onchange="toggleDepartmentField()">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                <option value="hostel" {{ $user->role == 'hostel' ? 'selected' : '' }}>Hostel</option>
                <option value="library" {{ $user->role == 'library' ? 'selected' : '' }}>Library</option>
                <option value="sports" {{ $user->role == 'sports' ? 'selected' : '' }}>Sports</option>
                <option value="computer_lab" {{ $user->role == 'computer_lab' ? 'selected' : '' }}>Computer Lab</option>
                <option value="estate" {{ $user->role == 'estate' ? 'selected' : '' }}>Estate</option>
                <option value="finance" {{ $user->role == 'finance' ? 'selected' : '' }}>Finance</option>
                <option value="hod" {{ $user->role == 'hod' ? 'selected' : '' }}>HoD</option>
            </select>
        </div>
        <div class="mb-3" id="department-group" style="display: {{ ($user->role == 'student' || $user->role == 'hod') ? 'block' : 'none' }};">
            <label for="department" class="form-label">Department</label>
            <select name="department" id="department" class="form-select">
                <option value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->name }}" {{ $user->department == $department->name ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" value="{{ $user->phone_number }}">
        </div>
        <button type="submit" class="btn btn-success">Update User</button>
        <a href="{{ route('admin.manage.users') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
function toggleDepartmentField() {
    var role = document.getElementById('role').value;
    var deptGroup = document.getElementById('department-group');
    if (role === 'student' || role === 'hod') {
        deptGroup.style.display = 'block';
    } else {
        deptGroup.style.display = 'none';
    }
}
</script>
@endsection