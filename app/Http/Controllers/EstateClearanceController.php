<?php

namespace App\Http\Controllers;

use App\Models\ClearanceRequest;
use Illuminate\Http\Request;

class EstateClearanceController extends Controller
{
    // Show all clearance requests for estate section
    public function dashboard()
    {
        $requests = ClearanceRequest::all();
        return view('departments.estate.index', compact('requests'));
    }

    // Approve estate section
    public function approve($id)
    {
        $request = ClearanceRequest::findOrFail($id);
        $request->estate_status = 'verified';
        $request->save();

        return back()->with('success', 'Estate section approved.');
    }

    // Reject estate section
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $clearance = ClearanceRequest::findOrFail($id);
        $clearance->estate_status = 'rejected';
        $clearance->estate_remarks = $request->reason;
        $clearance->save();

        return back()->with('success', 'Estate section rejected with reason.');
    }
}
