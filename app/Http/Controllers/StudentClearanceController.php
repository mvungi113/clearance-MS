<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClearanceRequest;

class StudentClearanceController extends Controller
{
    public function submitRequest(Request $request)
    {
        $request->validate([
            'reason' => 'required|string',
            'details' => 'nullable|string',
        ]);

        ClearanceRequest::create([
            'student_id'   => Auth::id(),
            'student_name' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            'department'   => Auth::user()->department, // or set as needed
            'status'       => 'pending',
            'remarks'      => $request->details,
        ]);

        return back()->with('success', 'Clearance request submitted!');
    }

    public function status()
    {
        $requests = \App\Models\ClearanceRequest::where('student_id', auth()->id())->get();
        return view('students.clearance_status', compact('requests'));
    }
}
