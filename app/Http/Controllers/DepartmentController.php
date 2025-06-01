<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\ClearanceRequest;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function verifiedRequests()
    {
        $user = auth()->user();
        $role = strtolower($user->role);
        $statusFields = [
            'library' => 'library_status',
            'hostel' => 'hostel_status',
            'sports' => 'sports_status',
            'finance' => 'financial_status',
            'computer_lab' => 'computer_lab_status',
            'estate' => 'estate_status',
            'hod' => 'hod_status',
        ];
        $statusField = $statusFields[$role] ?? 'status';

        // Get all requests (or filter as needed)
        $requests = \App\Models\ClearanceRequest::where($statusField, 'verified')->get();

        return view('departments.verified_requests', compact('requests'));
    }

    public function unverifiedRequests()
    {
        $user = auth()->user();
        $role = strtolower($user->role);
        $statusFields = [
            'library' => 'library_status',
            'hostel' => 'hostel_status',
            'sports' => 'sports_status',
            'finance' => 'financial_status',
            'computer_lab' => 'computer_lab_status',
            'estate' => 'estate_status',
            'hod' => 'hod_status',
        ];
        $statusField = $statusFields[$role] ?? 'status';

        // Get all requests where the department-specific status is 'rejected'
        $requests = \App\Models\ClearanceRequest::where($statusField, 'rejected')->get();

        return view('departments.unverified_requests', compact('requests'));
    }
    public function profile()
    {
        $user = auth()->user();
        // If you want to pass department info, fetch it here as well
        $department = null;
        // Example: $department = Department::where('name', $user->department)->first();
        return view('departments.profile', compact('user', 'department'));
    }
    public function updatePassword(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = auth()->user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('password_success', 'Password updated successfully!');
    }
}
