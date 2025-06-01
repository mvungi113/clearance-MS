<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department; // Add this line

class AdminController extends Controller
{
    public function manageUsers(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('role')->orderBy('first_name')->get();

        return view('admin.manage_users', compact('users'));
    }

    // Example edit and delete methods for completeness (implement as needed)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $departments = Department::all(); // Adjust model name if needed
        return view('admin.edit_user', compact('user', 'departments'));
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required',
            'department' => ($request->role === 'student' || $request->role === 'hod') ? 'required|string|max:255' : 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'department' => ($request->role === 'student' || $request->role === 'hod') ? $request->department : null,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('admin.manage.users')->with('success', 'User updated successfully.');
    }
}
