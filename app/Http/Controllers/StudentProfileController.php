<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentProfileController extends Controller
{
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('password_success', 'Password updated successfully!');
    }
}
