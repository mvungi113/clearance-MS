<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ClearanceRequest;

class DepartmentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $department = $user->department;
        $role = $user->role; // assuming you have a 'role' column

        $generalDepartments = ['Library', 'Sports', 'Hostel', 'Financial'];

        if (in_array($department, $generalDepartments)) {
            // General departments see all requests
            $requests = \App\Models\ClearanceRequest::all();
        } else {
            // HoD: Only requests where the student's department matches the HoD's department
            $requests = \App\Models\ClearanceRequest::whereHas('student', function ($q) use ($department) {
                $q->where('department', $department);
            })->get();
        }

        return view('departments.dashboard', compact('requests'));
    }

    public function approve($id)
    {
        $request = \App\Models\ClearanceRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();
        return back()->with('success', 'Request approved.');
    }

    public function reject($id)
    {
        $request = \App\Models\ClearanceRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();
        return back()->with('success', 'Request rejected.');
    }
}
