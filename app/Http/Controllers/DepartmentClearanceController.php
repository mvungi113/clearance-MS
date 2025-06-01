<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ClearanceRequest;

class DepartmentClearanceController extends Controller
{
    public function requested()
    {
        $user = Auth::user();

        // Map role to the correct status column
        $roleToColumn = [
            'library' => 'library_status',
            'hostel' => 'hostel_status',
            'finance' => 'finance_status',
            'sports' => 'sports_status',
            'computer_lab' => 'computer_lab_status',
            'estate' => 'estate_status',
            'hod' => 'hod_status',
        ];

        foreach ($roleToColumn as $role => $column) {
            if ($user->hasRole($role)) {
                $requests = ClearanceRequest::where($column, 'pending')->get();
                return view('departments.requested', compact('requests', 'role'));
            }
        }

        // If not a department role, redirect or abort
        return redirect()->route('login');
    }
}
