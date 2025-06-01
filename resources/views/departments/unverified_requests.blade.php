{{-- filepath: resources/views/department/unverified_requests.blade.php --}}
@extends('layout.department')

@section('content')
<h4>Rejected Requests</h4>
@if($clearances->isEmpty())
    <div class="alert alert-info">No rejected requests found for your department.</div>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Department</th>
                <th>Date Rejected</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clearances as $clearance)
                <tr>
                    <td>{{ $clearance->student_name }}</td>
                    <td>{{ ucfirst($clearance->department) }}</td>
                    <td>{{ $clearance->updated_at->format('Y-m-d') }}</td>
                    <td>{{ $clearance->rejection_reason ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection