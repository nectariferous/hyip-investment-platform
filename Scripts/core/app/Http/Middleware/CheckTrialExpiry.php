<?php

namespace App\Http\Middleware;

use App\Models\GeneralSetting;
use Closure;
use Illuminate\Http\Request;

class CheckTrialExpiry
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

        $user = auth()->user();

        if($user->trial){
            $expiredAt = auth()->user()->created_at->addDays($general->free_trial ?? 0);
        }else{
            
            $expiredAt = auth()->user()->planSubscribe()->where('payment_status',1)->first() ?  auth()->user()->planSubscribe->expired_at : now();
        }

        if($expiredAt->lt(now())){
            return redirect()->route('plan');
        }

        return $next($request);
    }
}
