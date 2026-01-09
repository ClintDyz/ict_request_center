<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Ensure this import is here

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override the username field.
     *
     * @return string
     */
    protected function username()
    {
        return 'username';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            'username' => $request->get('username'),
            'password' => $request->get('password'),
        ];
    }

    protected function redirectTo()
{
    $userType = auth()->user()->emp_type;

    if ($userType == '0') {
        return '/'; // Admin dashboard
    } elseif ($userType == '1') {
        return '/approved-speakers'; // Evaluator/Specific User dashboard
    } elseif ($userType == '2') {
        return '/masterlist';
    } else {
        return '/'; // Default redirect
    }
}
}
