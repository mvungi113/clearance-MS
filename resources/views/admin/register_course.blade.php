@extends('layout.admin')

@section('content')
<style>
    /* Remove input border glow on focus */
    .form-control:focus, .form-select:focus {
        box-shadow: none !important;
        border-color: #ced4da !important;
    }
    /* Make all .btn-primary green */
    .btn-primary {
        background-color: #198754 !important;
        border-color: #198754 !important;
    }
    .btn-primary:hover, .btn-primary:focus {
        background-color: #157347 !important;
        border-color: #146c43 !important;
    }
</style>
<div class="container mt-4">
    <h4>Register New Course or Department</h4>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <form method="POST" action="{{ route('admin.save.course') }}">
                @csrf
                <div class="mb-3">
                    <label for="course_name" class="form-label">Add New Course</label>
                    <input type="text" name="course_name" id="course_name" class="form-control" required pattern="^[A-Za-z0-9\s]+$" title="Only letters, numbers, and spaces allowed">
                </div>
                <button type="submit" class="btn btn-primary">Add Course</button>
            </form>
            <hr>
            <h6>Existing Courses</h6>
            <ul class="list-group">
                @foreach($courses as $course)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $course->name }}</span>
                        <span>
                            <a href="{{ route('admin.edit.course', $course->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.delete.course', $course->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this course?')">Delete</button>
                            </form>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-6">
            <form method="POST" action="{{ route('admin.save.department') }}">
                @csrf
                <div class="mb-3">
                    <label for="department_name" class="form-label">Add New Department</label>
                    <input type="text" name="department_name" id="department_name" class="form-control" required pattern="^[A-Za-z\s]+$" title="Only letters and spaces allowed">
                </div>
                <button type="submit" class="btn btn-primary">Add Department</button>
            </form>
            <hr>
            <h6>Existing Departments</h6>
            <ul class="list-group">
                @foreach($departments as $department)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $department->name }}</span>
                        <span>
                            <a href="{{ route('admin.edit.department', $department->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.delete.department', $department->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this department?')">Delete</button>
                            </form>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection