<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use App\Models\AdminPasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;


class ResetPasswordController extends Controller
{
   
    public $redirectTo = '/admin/home';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest');
    }

    public function showResetForm(Request $request, $token)
    {
        $pageTitle = "Account Recovery";

        $resetToken = AdminPasswordReset::where('token', $token)->where('status', 0)->first();

        if (!$resetToken) {
           
            return redirect()->route('admin.password.reset')->with(['error', 'Token not found!']);
        }
        $email = $resetToken->email;

        return view('backend.auth.reset', compact('pageTitle', 'email', 'token'));
    }


    public function reset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:4',
        ]);

        $reset = AdminPasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        $user = Admin::where('email', $reset->email)->first();
        if ($reset->status == 1) {
           
            return redirect()->route('admin.login')->with(['error', 'Invalid code']);
        }

        $user->password = bcrypt($request->password);
        $user->save();
        $reset->status = 1;
        $reset->save();

        $notify[] = ['success', 'Password changed'];
        return redirect()->route('admin.login')->withNotify($notify);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admins');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
