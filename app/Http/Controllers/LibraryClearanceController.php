<?php

namespace App\Http\Controllers;

use App\Models\ClearanceRequest;
use Illuminate\Http\Request;

class LibraryClearanceController extends Controller
{
    public function approve($id)
    {
        $request = ClearanceRequest::findOrFail($id);
        $request->library_status = 'verified';
        $request->save();

        return back()->with('success', 'Library section approved.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $clearance = ClearanceRequest::findOrFail($id);
        $clearance->library_status = 'rejected';
        $clearance->library_remarks = $request->reason;
        $clearance->save();

        return back()->with('success', 'Library section rejected with reason.');
    }

    public function dashboard()
    {
        $requests = \App\Models\ClearanceRequest::all();
        return view('departments.library.index', compact('requests'));
    }
}
