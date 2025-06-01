@extends('layout.department')

@section('content')
@if(auth()->user() && auth()->user()->role === 'estate')
<div class="container mt-4">
    <h3>Estate Clearance Requests</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Estate Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $request)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $request->student_name }}</td>
                    <td>
                        @if($request->estate_status === 'verified')
                            <span class="badge bg-success">Verified</span>
                        @elseif($request->estate_status === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($request->estate_status !== 'verified' && $request->estate_status !== 'rejected')
                            <form method="POST" action="{{ route('estate.approve', $request->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve Estate</button>
                            </form>
                            <form method="POST" action="{{ route('estate.reject', $request->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject Estate</button>
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
@else
    {{ abort(404) }}
@endif
@endsection