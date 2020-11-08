<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Auth;
use Socialite;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    protected $redirectTo = '/';

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

        return redirect('login')->withInput($request->only('email', 'remember'))->withErrors(['invalid'=>'You have entered invalid credentials']);
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


    // public function logout(Request $request)
    // {
    //     $request->user()->token()->revoke();

    //     return response()->json([
    //         'message' => 'Successfully logged out'
    //     ]);
    // }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect('/');

            }else{
                $newUser = User::where('email', $user->email)->first();
                if($newUser) {
                    $newUser->update([
                        'google_id'=> $user->id
                    ]);
                    if(Auth::attempt($newUser, $request->has('remember'))){
                        return redirect()->intended('home');
                    }
                }else{
                    return redirect('/login');
                }   
            }

        } catch (Exception $e) {
            return redirect('auth/google');
        }
    }
}
