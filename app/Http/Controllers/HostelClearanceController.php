<?php

namespace App\Http\Controllers;

use App\Models\ClearanceRequest;
use Illuminate\Http\Request;

class HostelClearanceController extends Controller
{
    public function dashboard()
    {
        $requests = ClearanceRequest::all();
        return view('departments.hostel.index', compact('requests'));
    }

    public function approve($id)
    {
        $request = ClearanceRequest::findOrFail($id);
        $request->hostel_status = 'verified';
        $request->save();

        return back()->with('success', 'Hostel section approved.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $clearance = ClearanceRequest::findOrFail($id);
        $clearance->hostel_status = 'rejected';
        $clearance->hostel_remarks = $request->reason;
        $clearance->save();

        return back()->with('success', 'Hostel section rejected with reason.');
    }
}
