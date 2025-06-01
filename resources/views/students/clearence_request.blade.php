@extends('layout.student')

@section('content')
@if(auth()->user() && auth()->user()->role === 'student')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex align-items-center">
                <i class="bi bi-journal-plus text-primary fs-3 me-2"></i>
                <h5 class="mb-0">Submit Clearance Request</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('student.clearance.request') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="details" class="form-label">Details <span class="text-muted">(optional)</span></label>
                        <textarea name="details" id="details" class="form-control" rows="4" placeholder="Provide any relevant details for your clearance request..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-send me-1"></i> Submit Request
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@else
    {{ abort(404) }}
@endif
@endsection