@extends('layout.student')

@section('content')
@php
    if (!auth()->user() || auth()->user()->role !== 'student') {
        abort(404);
    }
@endphp

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-clipboard-check text-success me-2"></i>My Clearance Status</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($requests->isEmpty())
            <div class="alert alert-info text-center py-4">
                <i class="bi bi-info-circle fs-2 mb-2"></i>
                <div>You have not submitted any clearance requests yet.</div>
            </div>
        @else
            @php
                $request = $requests->last(); // Show the latest request
                $allVerified =
                    ($request->library_status === 'verified') &&
                    ($request->hostel_status === 'verified') &&
                    ($request->financial_status === 'verified') &&
                    ($request->sports_status === 'verified') &&
                    ($request->hod_status === 'verified') &&
                    ($request->estate_status === 'verified') &&
                    ($request->computer_lab_status === 'verified');
            @endphp
            <div class="table-responsive">
                <table class="table table-bordered table-striped w-100 w-md-75 mx-auto align-middle">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Reason</th>
                            <th>Repost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $departments = [
                                'library' => ['Library', 'bi-book'],
                                'hostel' => ['Hostel', 'bi-house-door'],
                                'financial' => ['Financial', 'bi-cash-coin'],
                                'sports' => ['Sports', 'bi-trophy'],
                                'hod' => ['HoD', 'bi-person-badge'],
                                'estate' => ['Estate', 'bi-building'],
                                'computer_lab' => ['Computer Lab', 'bi-pc-display'],
                            ];
                            $allProcessed = true;
                            foreach($departments as $key => [$label, $icon]) {
                                if (($request[$key . '_status'] ?? 'pending') === 'pending') {
                                    $allProcessed = false;
                                    break;
                                }
                            }
                        @endphp
                        @foreach($departments as $key => [$label, $icon])
                        <tr>
                            <th><i class="bi {{ $icon }} me-1"></i> {{ $label }}</th>
                            <td>
                                <span class="badge
                                    @if($request[$key . '_status'] === 'verified')
                                        bg-success
                                    @elseif($request[$key . '_status'] === 'rejected')
                                        bg-danger
                                    @else
                                        bg-warning text-dark
                                    @endif
                                " data-bs-toggle="tooltip" title="{{ ucfirst($request[$key . '_status'] ?? 'pending') }}">
                                    @if($request[$key . '_status'] === 'verified')
                                        <i class="bi bi-check-circle me-1"></i>
                                    @elseif($request[$key . '_status'] === 'rejected')
                                        <i class="bi bi-x-circle me-1"></i>
                                    @else
                                        <i class="bi bi-hourglass-split me-1"></i>
                                    @endif
                                    {{ ucfirst($request[$key . '_status'] ?? 'pending') }}
                                </span>
                            </td>
                            <td>
                                @if($request[$key . '_status'] === 'rejected' && !empty($request[$key . '_remarks']))
                                    <small class="text-danger">{{ $request[$key . '_remarks'] }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($request[$key . '_status'] === 'rejected' && $request->student_id === auth()->id())
                                    <form method="POST" action="{{ route('student.clearance.repost', [$request->id, $key]) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="bi bi-arrow-repeat"></i> Repost
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                   
                        <tr>
                            <th><i class="bi bi-flag me-1"></i> Download Clearance</th>
                            <td>
                                @php
                                    $allDone = true;
                                    foreach($departments as $key => [$label, $icon]) {
                                        $status = $request[$key . '_status'] ?? 'pending';
                                        if ($status === 'pending') {
                                            $allDone = false;
                                            break;
                                        }
                                    }
                                @endphp
                                @if($allDone)
                                    <a href="{{ route('student.clearance.download', $request->id) }}" class="btn btn-primary btn-sm" target="_blank">
                                        <i class="bi bi-download"></i> Download Clearance
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="bi bi-download"></i> Download Clearance
                                    </button>
                                    {{-- <span class="text-muted ms-2">Clearance will be available after all departments process your request.</span> --}}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
<script>
    // Enable Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

@endsection