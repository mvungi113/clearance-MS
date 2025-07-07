<?php

namespace App\Http\Controllers;

use App\Models\ClearanceRequest;
use Illuminate\Http\Request;

class ComputerLabClearanceController extends Controller
{
    public function dashboard()
    {
        $requests = ClearanceRequest::all();
        return view('departments.computer-lab.index', compact('requests'));
    }

    public function approve($id)
    {
        $request = ClearanceRequest::findOrFail($id);
        $request->computer_lab_status = 'verified';
        $request->save();

        return back()->with('success', 'Computer Lab section approved.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $clearance = ClearanceRequest::findOrFail($id);
        $clearance->computer_lab_status = 'rejected';
        $clearance->computer_lab_remarks = $request->reason;
        $clearance->save();

        return back()->with('success', 'Computer Lab section rejected with reason.');
    }
}
