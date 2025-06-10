@extends('layout.admin')

@section('content')
@php
    if (!auth()->user() || auth()->user()->role !== 'admin') {
        abort(404);
    }
@endphp

<div class="container mt-4">
    <h4>Edit Course</h4>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form method="POST" action="{{ route('admin.update.course', $course->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Course Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $course->name }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update Course</button>
        <a href="{{ route('admin.register.course') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection