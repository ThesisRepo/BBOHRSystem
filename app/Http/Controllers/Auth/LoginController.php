<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * Redirects to the login blade view.
     * 
     */
    public function login()
    {
        return view('auth.login');
    }
    
    /**
     * Authenticates the user.
     * 
     * 
     */
    public function authenticate(LoginRequest $request)
    {
        
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials, $request->has('remember'))){
            return redirect()->intended('home');
        }

        return redirect('login')->with('error', 'Opps! You have entered invalid credentials');
    }

    /**
     * Logout the account.
     * 
     */
    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }
}
