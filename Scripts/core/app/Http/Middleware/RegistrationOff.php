<?php

namespace App\Http\Middleware;

use App\Models\GeneralSetting;
use Closure;
use Illuminate\Http\Request;

class RegistrationOff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $general = GeneralSetting::first();

        if($general){
            if(!$general->user_reg){
                $notify[] = ['error','System Registration Is off'];
                return back()->withNotify($notify);
            }
        }

        return $next($request);
    }
}
