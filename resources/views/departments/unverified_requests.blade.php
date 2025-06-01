{{-- filepath: resources/views/departments/unverified_requests.blade.php --}}
@extends('layout.department')

@section('content')
@php
    $role = strtolower(auth()->user()->role);
@endphp

@if(auth()->user())
    <div class="container mt-4">
        <h3 class="mb-4 text-capitalize">{{ $role }} Rejected Clearance Requests</h3>
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
                @php $i = 1; @endphp
                @foreach($requests as $request)
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
                    @if($status === 'rejected')
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $request->student_name }}</td>
                            <td>
                                <span class="badge bg-danger">Rejected</span>
                            </td>
                            <td>
                                <span class="text-muted">No action</span>
                            </td>
                        </tr>
                    @endif
                @endforeach
                @if($i === 1)
                    <tr>
                        <td colspan="4">No rejected clearance requests found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@else
    {{ abort(404) }}
@endif
@endsection