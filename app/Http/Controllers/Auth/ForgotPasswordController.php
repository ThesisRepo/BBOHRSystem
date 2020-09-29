<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

class ForgotPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Redirects to the forgot password blade file.
     * 
     */
    public function getEmail()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send an email to receive the password reset link.
     * 
     */
    public function postEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);

        $token = Str::random(60);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );
        
        $user = User::where('email', request()->input('email'))->first();
        try{
            $user->sendPasswordResetNotification($token);

            return back()->with('status', 'We have e-mailed your password reset link!');
        }
        catch (Exception $e){
            
            return back()->with('error', 'something went horrible!');
        }
            

    }
}
