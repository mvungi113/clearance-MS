<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentClearanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HodClearanceController;
use App\Http\Controllers\ComputerLabClearanceController;
use App\Http\Controllers\FinancialClearanceController;
use App\Http\Controllers\SportsClearanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentDashboardController;
use App\Http\Controllers\LibraryClearanceController;
use App\Http\Controllers\HostelClearanceController;
use App\Http\Controllers\EstateClearanceController;
use App\Http\Controllers\DepartmentClearanceController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Show login form (GET)
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

// Handle login POST
Route::post('/', [LoginController::class, 'login'])->name('login');

// Show register form
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Handle register POST
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/student', function () {
    return view('students.index');
})->name('student.dashboard');

Route::get('/student/clearance-request', function () {
    return view('students.clearence_request');
})->name('student.clearance.request.form');

// Handle logout POST
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/student/clearance-request', [StudentClearanceController::class, 'submitRequest'])
    ->name('student.clearance.request');

Route::get('/student/clearance-status', [StudentClearanceController::class, 'status'])
    ->name('student.clearance.status');

Route::post('/student/profile/password', [\App\Http\Controllers\StudentProfileController::class, 'updatePassword'])
    ->name('student.profile.password');

Route::get('/student/profile', function () {
    return view('students.profile');
})->name('student.profile');


// Admin-only routes (no middleware)
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.dashboard');

Route::get('/admin/register-users', [RegisterController::class, 'showRegisterUserForm'])
    ->name('admin.register.users');

Route::get('/admin/register-course', [RegisterController::class, 'showAdminRegisterCourseForm'])
    ->name('admin.register.course');

Route::post('/admin/save-course', [RegisterController::class, 'saveCourse'])->name('admin.save.course');
Route::post('/admin/save-department', [RegisterController::class, 'saveDepartment'])->name('admin.save.department');

// Course routes
Route::get('/admin/course/{id}/edit', [RegisterController::class, 'editCourse'])->name('admin.edit.course');
Route::put('/admin/course/{id}', [RegisterController::class, 'updateCourse'])->name('admin.update.course');
Route::delete('/admin/course/{id}', [RegisterController::class, 'deleteCourse'])->name('admin.delete.course');

// Department routes
Route::get('/admin/department/{id}/edit', [RegisterController::class, 'editDepartment'])->name('admin.edit.department');
Route::put('/admin/department/{id}', [RegisterController::class, 'updateDepartment'])->name('admin.update.department');
Route::delete('/admin/department/{id}', [RegisterController::class, 'deleteDepartment'])->name('admin.delete.department');

// User management
Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manage.users');
Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
Route::delete('/admin/users/{id}', [AdminController::class, 'delete'])->name('admin.users.delete');
Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');

// Department dashboards
Route::get('/department/dashboard', [DepartmentDashboardController::class, 'index'])->name('department.dashboard');
Route::post('/department/{id}/approve', [DepartmentDashboardController::class, 'approve'])->name('department.approve');
Route::post('/department/{id}/reject', [DepartmentDashboardController::class, 'reject'])->name('department.reject');
Route::post('/department/{id}/verify', [DepartmentDashboardController::class, 'verifyDepartment'])->name('department.verify');
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('/department/verified-requests', [DepartmentController::class, 'verifiedRequests'])->name('departments.verified_requests');
Route::get('/department/unverified-requests', [DepartmentController::class, 'unverifiedRequests'])->name('departments.unverified_requests');
Route::get('/department/profile', [DepartmentController::class, 'profile'])->name('departments.profile');

// Library department
Route::get('/department/library', [LibraryClearanceController::class, 'dashboard'])->name('library.dashboard');
Route::post('/department/library/{id}/approve', [LibraryClearanceController::class, 'approve'])->name('library.approve');
Route::post('/department/library/{id}/reject', [LibraryClearanceController::class, 'reject'])->name('library.reject');

// Hostel department
Route::get('/department/hostel', [HostelClearanceController::class, 'dashboard'])->name('hostel.dashboard');
Route::post('/department/hostel/{id}/approve', [HostelClearanceController::class, 'approve'])->name('hostel.approve');
Route::post('/department/hostel/{id}/reject', [HostelClearanceController::class, 'reject'])->name('hostel.reject');

// HoD department
Route::get('/department/hod', [HodClearanceController::class, 'dashboard'])->name('hod.dashboard');
Route::post('/department/hod/{id}/approve', [HodClearanceController::class, 'approve'])->name('hod.approve');
Route::post('/department/hod/{id}/reject', [HodClearanceController::class, 'reject'])->name('hod.reject');

// Estate department
Route::get('/department/estate', [EstateClearanceController::class, 'dashboard'])->name('estate.dashboard');
Route::post('/department/estate/{id}/approve', [EstateClearanceController::class, 'approve'])->name('estate.approve');
Route::post('/department/estate/{id}/reject', [EstateClearanceController::class, 'reject'])->name('estate.reject');

// Computer Lab department
Route::get('/department/computer-lab', [ComputerLabClearanceController::class, 'dashboard'])->name('computer_lab.dashboard');
Route::post('/department/computer-lab/{id}/approve', [ComputerLabClearanceController::class, 'approve'])->name('computer_lab.approve');
Route::post('/department/computer-lab/{id}/reject', [ComputerLabClearanceController::class, 'reject'])->name('computer_lab.reject');

// Financial department
Route::get('/department/finance', [FinancialClearanceController::class, 'dashboard'])->name('financial.dashboard');
Route::post('/department/finance/{id}/approve', [FinancialClearanceController::class, 'approve'])->name('financial.approve');
Route::post('/department/finance/{id}/reject', [FinancialClearanceController::class, 'reject'])->name('financial.reject');

// Sports department
Route::get('/department/sports', [SportsClearanceController::class, 'dashboard'])->name('sports.dashboard');
Route::post('/department/sports/{id}/approve', [SportsClearanceController::class, 'approve'])->name('sports.approve');
Route::post('/department/sports/{id}/reject', [SportsClearanceController::class, 'reject'])->name('sports.reject');

Route::post('/student/clearance/{id}/approve', [StudentClearanceController::class, 'approve'])->name('student.clearance.approve');
Route::get('/student/clearance/{id}/download', [StudentClearanceController::class, 'download'])->name('student.clearance.download');

Route::get('/department/requested', [DepartmentClearanceController::class, 'requested'])->name('department.requested');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::get('/admin/profile', function () {
        return view('admin.profile');
    })->name('admin.profile');

// Add this route for admin to register users
Route::post('/admin/register-user', [RegisterController::class, 'registerByAdmin'])->name('admin.register.user');

Route::redirect('/department', '/department/dashboard');
Route::post('/department/profile/password', [DepartmentController::class, 'updatePassword'])->name('department.profile.password');