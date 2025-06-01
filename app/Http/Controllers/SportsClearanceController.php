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

    public function reject($id)
    {
        $request = ClearanceRequest::findOrFail($id);
        $request->sports_status = 'rejected';
        $request->save();

        return back()->with('success', 'Sports section rejected.');
    }
}
