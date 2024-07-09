<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    public function __construct()
    {
        $general = GeneralSetting::first();
        $this->template = $general->theme == 1 ? 'frontend.' : "theme{$general->theme}.";
    }



    public function index()
    {
       $pageTitle = 'Login Page';

       return view($this->template.'user.auth.login',compact('pageTitle'));
    }

    public function login(Request $request)
    {
       $general  = GeneralSetting::first();
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'g-recaptcha-response'=>Rule::requiredIf($general->allow_recaptcha == 1)
        ],[
            'g-recaptcha-response.required' => 'You Have To fill recaptcha'
        ]);


        $user = User::where('email',$request->email)->first();

        if(!$user){
            $notify[] = ['error','No user found associated with this email'];
             return redirect()->route('user.login')->withNotify($notify);
        }

        
   
        if (Auth::attempt($request->except('g-recaptcha-response','_token'))) {


            $notify[] = ['success','Successfully logged in'];

            return redirect()->route('user.dashboard')
                        ->withNotify($notify);
        }
        
        $notify[] = ['error','Invalid Credentials'];
        return redirect()->route('user.login')->withNotify($notify);
    }

    
    public function emailVerify()
    {
       $pageTitle = "Email Verify";

       return view('frontend.user.auth.email',compact('pageTitle'));
    }

    public function emailVerifyConfirm(Request $request)
    {
        $request->validate(['code' => 'required']);
        
        $user = User::findOrFail(session('user'));

        if($request->code == $user->verification_code){
            $user->verification_code = null;
            $user->email_verified_at = now();
            $user->status = 1;

            $user->last_login = now();
            $user->save();



            Auth::login($user);

            $notify[] = ['success','Successfully verify your account'];

            return redirect()->route('user.dashboard')->withNotify($notify);
        }

        $notify[] = ['error','Invalid Code'];

        return back()->withNotify($notify);
    }
}
