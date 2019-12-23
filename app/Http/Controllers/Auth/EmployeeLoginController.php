<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

class EmployeeLoginController extends LoginController
{
    // protected $redirectTo = '/employee/home';

    public function __construct()
    {
        $this->middleware('guest:employee')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('employee');
    }

    public function showLoginForm()
    {
        return view('auth.employee-login');
    }
}