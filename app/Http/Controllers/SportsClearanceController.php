<?php

namespace App\Http\Controllers;

use App\Models\ClearanceRequest;
use Illuminate\Http\Request;

class SportsClearanceController extends Controller
{
    public function dashboard()
    {
        $requests = \App\Models\ClearanceRequest::all();
        return view('departments.sports.index', compact('requests'));
    }

    public function approve($id)
    {
        $request = ClearanceRequest::findOrFail($id);
        $request->sports_status = 'verified';
        $request->save();

        return back()->with('success', 'Sports section approved.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $clearance = ClearanceRequest::findOrFail($id);
        $clearance->sports_status = 'rejected';
        $clearance->sports_remarks = $request->reason;
        $clearance->save();

        return back()->with('success', 'Sports section rejected with reason.');
    }
}
