{{-- filepath: resources/views/departments/verified_requests.blade.php --}}
@extends('layout.department')

@section('content')
    <h4>Verified Requests</h4>
    @if($clearances->isEmpty())
        <div class="alert alert-info">No verified requests found for your department.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Student Email</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Date Verified</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clearances as $clearance)
                    <tr>
                        <td>{{ $clearance->student ? $clearance->student->first_name . ' ' . $clearance->student->last_name : 'N/A' }}</td>
                        <td>{{ $clearance->student ? $clearance->student->email : 'N/A' }}</td>
                        <td>{{ ucfirst($clearance->department) }}</td>
                        <td>{{ ucfirst($clearance->status) }}</td>
                        <td>{{ $clearance->updated_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection