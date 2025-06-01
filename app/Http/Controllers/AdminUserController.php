<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function saveCourse(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255|unique:courses,name',
        ]);
        \App\Models\Course::create(['name' => $request->course_name]);
        return redirect()->route('admin.register.course')->with('success', 'Course added successfully!');
    }
}
