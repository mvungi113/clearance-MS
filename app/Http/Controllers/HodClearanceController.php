<?php

namespace App\Http\Controllers;

use App\Models\ClearanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HodClearanceController extends Controller
{
    // Show all clearance requests for students in the HoD's department
    public function dashboard()
    {
        $user = Auth::user();
        $department = $user->department;

        // Only show requests where the student's department matches the HoD's department
        $requests = ClearanceRequest::where('department', $department)->get();

        return view('departments.HoD.index', compact('requests'));
    }

    // Approve HoD section
    public function approve($id)
    {
        $request = ClearanceRequest::findOrFail($id);
        $request->hod_status = 'verified';
        $request->save();

        return back()->with('success', 'HoD section approved.');
    }

    // Reject HoD section
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $clearance = ClearanceRequest::findOrFail($id);
        $clearance->hod_status = 'rejected';
        $clearance->hod_remarks = $request->reason;
        $clearance->save();

        return back()->with('success', 'HoD section rejected with reason.');
    }
}
