<?php

namespace App\Http\Controllers;

use App\Models\ClearanceRequest;
use Illuminate\Http\Request;

class FinancialClearanceController extends Controller
{
    public function dashboard()
    {
        $requests = \App\Models\ClearanceRequest::all();
        return view('departments.finance.index', compact('requests'));
    }

    public function approve($id)
    {
        $request = ClearanceRequest::findOrFail($id);
        $request->financial_status = 'verified';
        $request->save();

        return back()->with('success', 'Financial section approved.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $clearance = ClearanceRequest::findOrFail($id);
        $clearance->financial_status = 'rejected';
        $clearance->financial_remarks = $request->reason;
        $clearance->save();

        return back()->with('success', 'Financial section rejected with reason.');
    }
}
