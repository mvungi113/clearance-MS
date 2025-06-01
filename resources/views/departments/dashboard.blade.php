{{-- filepath: resources/views/departments/dashboard.blade.php --}}
@extends('layout.department')

@section('content')
@php
    $role = auth()->user()->role;
@endphp

@if(auth()->user())
    <div class="container mt-4">
        <h3 class="mb-4 text-capitalize">{{ $role }} Clearance Requests</h3>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    @if($role === 'library')
                        <th>Library Status</th>
                    @elseif($role === 'hostel')
                        <th>Hostel Status</th>
                    @elseif($role === 'sports')
                        <th>Sports Status</th>
                    @elseif($role === 'computer_lab')
                        <th>Computer Lab Status</th>
                    @elseif($role === 'estate')
                        <th>Estate Status</th>
                    @elseif($role === 'finance')
                        <th>Financial Status</th>
                    @elseif($role === 'hod')
                        <th>HoD Status</th>
                    @endif
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $request->student_name }}</td>
                        @php
                            $status = match($role) {
                                'library' => $request->library_status,
                                'hostel' => $request->hostel_status,
                                'sports' => $request->sports_status,
                                'computer_lab' => $request->computer_lab_status,
                                'estate' => $request->estate_status,
                                'finance' => $request->financial_status,
                                'hod' => $request->hod_status,
                                default => null
                            };
                        @endphp
                        <td>
                            @if($status === 'verified')
                                <span class="badge bg-success">Verified</span>
                            @elseif($status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($status !== 'verified' && $status !== 'rejected')
                                <form method="POST" action="{{ route($role . '.approve', $request->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form method="POST" action="{{ route($role . '.reject', $request->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
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