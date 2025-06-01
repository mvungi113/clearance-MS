<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HodController extends Controller
{
    public function dashboard()
    {
        return view('department.hod.dashboard');
    }

    public function approve($id)
    {
        // Approve logic here
        // Example: HodClearance::find($id)->approve();
        return redirect()->back()->with('success', 'Clearance approved.');
    }

    public function reject($id)
    {
        // Reject logic here
        // Example: HodClearance::find($id)->reject();
        return redirect()->back()->with('error', 'Clearance rejected.');
    }
}
