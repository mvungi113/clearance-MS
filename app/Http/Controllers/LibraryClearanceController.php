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

    public function reject($id)
    {
        $request = ClearanceRequest::findOrFail($id);
        $request->library_status = 'rejected';
        $request->save();

        return back()->with('success', 'Library section rejected.');
    }

    public function dashboard()
    {
        $requests = \App\Models\ClearanceRequest::all();
        return view('departments.library.index', compact('requests'));
    }
}
