<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number'  => ['required', 'string', 'max:20'],
            'password'      => ['required', 'string', 'min:6', 'confirmed'],
            'role'          => ['required', 'string'],
        ];

        // Department is required for student and hod
        if (isset($data['role']) && in_array($data['role'], ['student', 'hod'])) {
            $rules['department'] = ['required', 'string', 'max:255'];
        }

        // Course is required for student only
        if (isset($data['role']) && $data['role'] === 'student') {
            $rules['course'] = ['required', 'string', 'max:255'];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
            'course'        => (isset($data['role']) && $data['role'] === 'student') ? $data['course'] : null,
            'department'    => (isset($data['role']) && in_array($data['role'], ['student', 'hod'])) ? $data['department'] : null,
            'phone_number'  => $data['phone_number'],
            'role'          => $data['role'],
            'password'      => Hash::make($data['password']),
        ]);
    }

    // ==================== FORM DISPLAY METHODS ====================

    // Show user registration form (for students)
    public function showRegistrationForm()
    {
        $courses = Course::all();
        $departments = Department::all();
        return view('auth.register', compact('courses', 'departments'));
    }

    // Show admin register user form
    public function showRegisterUserForm()
    {
        $courses = Course::all();
        $departments = Department::all();
        return view('admin.register_users', compact('courses', 'departments'));
    }

    // Show admin register course form
    public function showAdminRegisterCourseForm()
    {
        $courses = Course::all();
        $departments = Department::all();
        return view('admin.register_course', compact('courses', 'departments'));
    }

    // ==================== USER REGISTRATION METHODS ====================

    // Method for admin to register users (keeps admin logged in)
    public function registerByAdmin(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user without logging them in
        $user = $this->create($request->all());

        return redirect()->route('admin.manage.users')
            ->with('success', 'User registered successfully!');
    }

    // Handle normal student registration
    protected function registered(\Illuminate\Http\Request $request, $user)
    {
        // For normal registration, logout and redirect to login
        $this->guard()->logout();
        return redirect()->route('login')
            ->with('success', 'Registration successful! Please login.');
    }

    // ==================== COURSE MANAGEMENT METHODS ====================

    // Save a new course
    public function saveCourse(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255|unique:courses,name',
        ]);

        Course::create([
            'name' => $request->course_name,
        ]);

        return redirect()->back()->with('success', 'Course created successfully.');
    }

    // Edit a course
    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        $departments = Department::all();
        return view('admin.edit_course', compact('course', 'departments'));
    }

    // Update a course
    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name,' . $course->id,
        ]);

        $course->update([
            'name' => $request->name,
        ]);

        return redirect('/admin/register-course')->with('success', 'Course updated successfully.');
    }

    // Delete a course
    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->back()->with('success', 'Course deleted successfully.');
    }

    // ==================== DEPARTMENT MANAGEMENT METHODS ====================

    // Save a new department
    public function saveDepartment(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255|unique:departments,name',
        ]);

        Department::create([
            'name' => $request->department_name,
        ]);

        return redirect()->back()->with('success', 'Department created successfully.');
    }

    // Edit a department
    public function editDepartment($id)
    {
        $department = Department::findOrFail($id);
        return view('admin.edit_department', compact('department'));
    }

    // Update a department
    public function updateDepartment(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
        ]);

        $department->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.register.course')->with('success', 'Department updated successfully.');
    }

    // Delete a department
    public function deleteDepartment($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->back()->with('success', 'Department deleted successfully.');
    }
}
