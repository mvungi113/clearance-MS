<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClearanceRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentClearanceController extends Controller
{
    public function submitRequest(Request $request)
    {
        // Prevent duplicate requests
        if (ClearanceRequest::where('student_id', Auth::id())->exists()) {
            return back()->with('error', 'You have already submitted a clearance request.');
        }

        ClearanceRequest::create([
            'student_id'      => Auth::id(),
            'student_name'    => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            'department'      => Auth::user()->department,
            'course'          => Auth::user()->course ?? null,
            'status'          => 'pending',
            'remarks'         => null,
            'library_status'      => null,
            'library_remarks'     => null,
            'hostel_status'       => null,
            'hostel_remarks'      => null,
            'financial_status'    => null,
            'financial_remarks'   => null,
            'sports_status'       => null,
            'sports_remarks'      => null,
            'hod_status'          => null,
            'hod_remarks'         => null,
            'estate_status'       => null,
            'estate_remarks'      => null,
            'computer_lab_status' => null,
            'computer_lab_remarks'=> null,
        ]);

        return back()->with('success', 'Clearance request submitted!');
    }

    public function status()
    {
        $requests = ClearanceRequest::where('student_id', Auth::id())->get();
        return view('students.clearance_status', compact('requests'));
    }

    public function download($id)
    {
        $request = \App\Models\ClearanceRequest::findOrFail($id);

        // Only allow if the logged-in student owns this request
        if ($request->student_id !== auth()->id()) {
            abort(403);
        }

        $departments = [
            'library' => 'Library',
            'hostel' => 'Hostel',
            'financial' => 'Financial',
            'sports' => 'Sports',
            'hod' => 'HoD',
            'estate' => 'Estate',
            'computer_lab' => 'Computer Lab',
        ];

        $pdf = Pdf::loadView('students.clearance_pdf', [
            'request' => $request,
            'departments' => $departments,
        ]);

        return $pdf->download('clearance_certificate.pdf');
    }

    public function repost($id, $department)
    {
        $clearance = \App\Models\ClearanceRequest::findOrFail($id);

        // Only allow the owner to repost
        if ($clearance->student_id !== auth()->id()) {
            abort(403);
        }

        // Only reset the rejected department
        $clearance[$department . '_status'] = null;
        $clearance[$department . '_remarks'] = null;
        $clearance->save();

        return back()->with('success', ucfirst($department) . ' clearance reposted for review.');
    }
}
