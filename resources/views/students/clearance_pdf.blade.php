{{-- filepath: resources/views/students/clearance_pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Clearance Certificate</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #333; padding: 8px; }
        .approved { color: green; }
        .rejected { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Student Clearance Certificate</h2>
        <p><strong>Name:</strong> {{ $request->student_name }}</p>
        <p><strong>Department:</strong> {{ ucfirst($request->department) }}</p>
        <p><strong>Date:</strong> {{ $request->created_at->format('Y-m-d') }}</p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Section</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $key => $label)
            <tr>
                <td>{{ $label }}</td>
                <td>
                    @php $status = $request[$key . '_status'] ?? 'pending'; @endphp
                    @if($status === 'verified')
                        <span class="approved">Approved</span>
                    @elseif($status === 'rejected')
                        <span class="rejected">Rejected</span>
                        <br>
                        <small>
                            <em>
                                Your clearance request was not approved by the {{ $label }} department.
                                Please visit the {{ $label }} office for further assistance regarding your clearance.
                            </em>
                        </small>
                    @else
                        Pending
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>