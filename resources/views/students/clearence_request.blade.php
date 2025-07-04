@extends('layout.student')

@section('content')
@php
    if (!auth()->user() || auth()->user()->role !== 'student') {
        abort(404);
    }
@endphp

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex align-items-center">
                <i class="bi bi-journal-plus text-primary fs-3 me-2"></i>
                <h5 class="mb-0">Submit Clearance Request</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-4">
                    To request clearance, simply click the button below. Your request will be sent to the appropriate department for processing. No additional information is required.
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('student.clearance.request') }}">
                    @csrf
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-send me-1"></i> Request Clearance
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection