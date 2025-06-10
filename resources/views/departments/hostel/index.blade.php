@extends('layout.department')

@section('content')
<div class="container mt-4">
    <h3>Hostel Clearance Requests</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Hostel Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $request)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $request->student_name }}</td>
                    <td>
                        @if($request->hostel_status === 'verified')
                            <span class="badge bg-success">Verified</span>
                        @elseif($request->hostel_status === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($request->hostel_status !== 'verified' && $request->hostel_status !== 'rejected')
                            <form method="POST" action="{{ route('hostel.approve', $request->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve Hostel</button>
                            </form>
                            <form method="POST" action="{{ route('hostel.reject', $request->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject Hostel</button>
                            </form>
                        @else
                            <span class="text-muted">No action</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No clearance requests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection