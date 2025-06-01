<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class verifyDepartment extends Controller
{
    public function verifyDepartment($id)
    {
        $user = auth()->user();
        $department = strtolower($user->department); // e.g., 'library', 'hostel', 'ict'

        $request = \App\Models\ClearanceRequest::findOrFail($id);

        // Determine which status field to update
        $statusField = null;
        if ($department === 'library') {
            $statusField = 'library_status';
        } elseif ($department === 'hostel') {
            $statusField = 'hostel_status';
        } elseif ($department === 'financial') {
            $statusField = 'financial_status';
        } elseif ($department === 'sports') {
            $statusField = 'sports_status';
        } else {
            // Assume HOD (academic department)
            // Only allow if student's department matches HOD's department
            if ($request->student->department === $user->department) {
                $statusField = 'hod_status';
            }
        }

        if ($statusField) {
            $request->$statusField = 'verified';
            $request->save();

            // Auto-approve if all are verified
            if (
                $request->library_status === 'verified' &&
                $request->hostel_status === 'verified' &&
                $request->financial_status === 'verified' &&
                $request->sports_status === 'verified' &&
                $request->hod_status === 'verified'
            ) {
                $request->status = 'approved';
                $request->save();
            }

            return back()->with('success', ucfirst($department).' verified!');
        }

        return back()->with('error', 'You are not authorized to verify this request.');
    }
}
