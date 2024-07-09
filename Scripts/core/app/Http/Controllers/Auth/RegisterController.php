<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;


class RegisterController extends Controller
{

    public function __construct()
    {
        $general = GeneralSetting::first();
        $this->template = $general->theme == 1 ? 'frontend.' : "theme{$general->theme}.";
    }



    public function index()
    {
        $pageTitle = 'Register User';

        return view($this->template.'user.auth.register', compact('pageTitle'));
    }

    public function register(Request $request)
    {

        $general = GeneralSetting::first();

        $signupBonus = $general->signup_bonus;

        $request->validate([
            'reffered_by' => 'sometimes',
            'fname' => 'required',
            'lname' => 'required',
            'username' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'g-recaptcha-response' => Rule::requiredIf($general->allow_recaptcha == 1)

        ], [
            'fname.required' => 'First name is required',
            'lname.required' => 'Last name is required',
            'g-recaptcha-response.required' => 'You Have To fill recaptcha'
        ]);


        $referid = 0;


        if ($request->reffered_by) {
            $referUser = User::where('username', $request->reffered_by)->first();

            $referid = $referUser->id;

            if (!$referUser) {
                $notify[] = ['error', 'No User Found Assocciated with this reffer Name'];

                return redirect()->route('user.register')->withNotify($notify);
            }
        }

        event(new Registered($user = $this->create($request, $signupBonus, $referid)));

        Auth::login($user);

        $notify[] = ['success', 'Successfully Registered'];

        return redirect()->route('user.dashboard')->withNotify($notify);
    }

    public function dashboard()
    {
        if (auth()->check()) {
            return view($this->template.'user.dashboard');
        }

        return redirect()->route('user.login')->withSuccess('You are not allowed to access');
    }

    public function create($request, $signupBonus, $referid)
    {
        return User::create([
            'fname' => $request->fname,
            'balance' => $signupBonus,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 1,
            'password' => bcrypt($request->password),
            'reffered_by' => $referid ?? ''
        ]);
    }

    public function signOut()
    {
        Auth::logout();

        return Redirect()->route('user.login');
    }
}
