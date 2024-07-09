<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use App\Models\AdminPasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $pageTitle = 'Account Recovery';

        AdminPasswordReset::truncate();

        return view('backend.auth.email', compact('pageTitle'));
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

    public function sendResetCodeEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        
        $user = Admin::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['Email Not Available']);
        }

        $code = verificationCode(6);

        AdminPasswordReset::create([
            'email' => $user->email,
            'token' => $code,
            'status' => 0
        ]);

        sendMail('PASSWORD_RESET', [
            'code' => $code,
        ],$user);

        $pageTitle = 'Account Recovery';

        return view('backend.auth.code_verify', compact('pageTitle'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required']);
        $notify[] = ['success', 'You can change your password.'];
        $code = str_replace(' ', '', $request->code);
        return redirect()->route('admin.password.reset.form', $code)->withNotify($notify);
    }

   
}
