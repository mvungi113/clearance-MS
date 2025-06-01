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

    public function reject($id)
    {
        $request = ClearanceRequest::findOrFail($id);
        $request->financial_status = 'rejected';
        $request->save();

        return back()->with('success', 'Financial section rejected.');
    }
}
