@extends('layout.student')

@section('content')

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
                    <tbody>
                        <tr>
                            <th><i class="bi bi-calendar-event me-1"></i> Date Submitted</th>
                            <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-chat-left-text me-1"></i> Details</th>
                            <td>{{ $request->details ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-flag me-1"></i> Status</th>
                            <td>
                                @if($allVerified && $request->status !== 'approved')
                                    <form method="POST" action="{{ route('student.clearance.approve', $request->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                    </form>
                                @elseif($request->status === 'approved')
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Approved</span>
                                    <a href="{{ route('student.clearance.download', $request->id) }}" class="btn btn-primary btn-sm ms-2" target="_blank">
                                        <i class="bi bi-download"></i> Download Clearance
                                    </a>
                                @elseif($request->status === 'pending')
                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                @elseif($request->status === 'rejected')
                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Rejected</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($request->status) }}</span>
                                @endif
                            </td>
                        </tr>
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
                        </tr>
                        @endforeach
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