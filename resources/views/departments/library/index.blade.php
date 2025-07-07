{{-- filepath: resources/views/departments/library/index.blade.php --}}
@extends('layout.department')

@section('content')
<div class="container mt-4">
    <h3>Library Clearance Requests</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Library Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $request)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $request->student_name }}</td>
                    <td>
                        @if($request->library_status === 'verified')
                            <span class="badge bg-success">Verified</span>
                        @elseif($request->library_status === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                            @if($request->library_remarks)
                                <br>
                                <small class="text-danger">Reason: {{ $request->library_remarks }}</small>
                            @endif
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($request->library_status !== 'verified' && $request->library_status !== 'rejected')
                            <form method="POST" action="{{ route('library.approve', $request->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve Library</button>
                            </form>
                            <button type="button" class="btn btn-danger btn-sm" onclick="showReasonInput({{ $request->id }})" id="reject-btn-{{ $request->id }}">Reject Library</button>
                            <form method="POST" action="{{ route('library.reject', $request->id) }}" style="display:inline; display:none;" id="reason-form-{{ $request->id }}">
                                @csrf
                                <input type="text" name="reason" placeholder="Reason" required class="form-control d-inline-block w-auto" style="width: 120px; margin-right: 5px;">
                                <button type="submit" class="btn btn-danger btn-sm">Submit Reason</button>
                            </form>
                            <script>
                                function showReasonInput(id) {
                                    document.getElementById('reject-btn-' + id).style.display = 'none';
                                    document.getElementById('reason-form-' + id).style.display = 'inline';
                                }
                            </script>
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