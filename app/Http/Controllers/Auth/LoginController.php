<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $role = auth()->user()->role;

        switch ($role) {
            case 'student':
                return route('student.dashboard');
            case 'library':
                return route('library.dashboard');
            case 'hostel':
                return route('hostel.dashboard');
            case 'finance':
                return route('financial.dashboard');
            case 'sports':
                return route('sports.dashboard');
            case 'hod':
                return route('hod.dashboard');
            case 'estate':
                return route('estate.dashboard');
            case 'computer_lab':
                return route('computer_lab.dashboard');
            case 'admin':
                return route('admin.dashboard');
            default:
                // Optionally, you can redirect to login or home if role is unknown
                return route('login');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
}
