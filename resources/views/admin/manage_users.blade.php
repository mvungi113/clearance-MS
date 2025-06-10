@extends('layout.admin')

@section('content')

<div class="container mt-4">
    <h3>Manage Users</h3>
    <form method="GET" action="{{ route('admin.manage.users') }}" class="mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label for="role" class="form-label">Sort by Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="hostel" {{ request('role') == 'hostel' ? 'selected' : '' }}>Hostel</option>
                    <option value="library" {{ request('role') == 'library' ? 'selected' : '' }}>Library</option>
                    <option value="sports" {{ request('role') == 'sports' ? 'selected' : '' }}>Sports</option>
                    <option value="computer_lab" {{ request('role') == 'computer_lab' ? 'selected' : '' }}>Computer Lab</option>
                    <option value="estate" {{ request('role') == 'estate' ? 'selected' : '' }}>Estate</option>
                    <option value="finance" {{ request('role') == 'finance' ? 'selected' : '' }}>Finance</option>
                    <option value="hod" {{ request('role') == 'hod' ? 'selected' : '' }}>HoD</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Sort</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Department</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $user->role)) }}</td>
                    <td>{{ $user->department ?? '-' }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection