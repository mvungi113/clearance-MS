@extends('layout.admin')
@section('content')
<div class="container mt-4">
    <h4>Edit Department</h4>
    <form method="POST" action="{{ route('admin.update.department', $department->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Department Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $department->name }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update Department</button>
    </form>
</div>
@endsection