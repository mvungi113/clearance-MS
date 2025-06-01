@extends('layout.admin')
@section('content')
<div class="container mt-4">
    <h4>Edit Course</h4>
    <form method="POST" action="{{ route('admin.update.course', $course->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Course Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $course->name }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update Course</button>
    </form>
</div>
@endsection