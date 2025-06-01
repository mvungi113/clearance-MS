<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ClearanceRequest;
use Illuminate\Http\Request;

class DepartmentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $department = strtolower($user->department);
        $role = strtolower($user->role);

        // List all department roles that should see all requests for their section
        $generalDepartments = ['library', 'sports', 'hostel', 'finance', 'computer_lab', 'estate'];

        if (in_array($role, $generalDepartments)) {
            // Department staff: See all requests
            $requests = ClearanceRequest::all();
        } elseif ($role === 'hod') {
            // HoD: Only requests where the student's department matches the HoD's department
            $requests = ClearanceRequest::whereHas('student', function ($q) use ($department) {
                $q->where('department', $department);
            })->get();
        } else {
            // Fallback: show nothing
            $requests = collect();
        }

        // Dynamically load the dashboard view for the department if it exists
        $viewPath = "departments.$role.index";
        if (view()->exists($viewPath)) {
            return view($viewPath, compact('requests'));
        }

        // Fallback to a general dashboard
        return view('departments.dashboard', compact('requests'));
    }

    public function approve($id)
    {
        $request = ClearanceRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();
        return back()->with('success', 'Request approved.');
    }

    public function reject($id)
    {
        $request = ClearanceRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();
        return back()->with('success', 'Request rejected.');
    }
}
