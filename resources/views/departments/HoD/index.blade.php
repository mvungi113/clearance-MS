@extends('layout.department')

@section('content')
@if(auth()->user() && auth()->user()->role === 'hod')
<div class="container mt-4">
    <h3>HoD Clearance Requests</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Department</th>
                <th>HoD Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $request)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $request->student_name }}</td>
                    <td>{{ $request->department }}</td>
                    <td>
                        @if($request->hod_status === 'verified')
                            <span class="badge bg-success">Verified</span>
                        @elseif($request->hod_status === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($request->hod_status !== 'verified' && $request->hod_status !== 'rejected')
                            <form method="POST" action="{{ route('hod.approve', $request->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve HoD</button>
                            </form>
                            <form method="POST" action="{{ route('hod.reject', $request->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject HoD</button>
                            </form>
                        @else
                            <span class="text-muted">No action</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No clearance requests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@else
    {{ abort(404) }}
@endif
@endsection