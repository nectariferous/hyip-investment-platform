<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DemoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       
        $mode = env('DEMO') ?? false;
        
        if($mode){
            if(request()->method() != 'GET'){
                $notify[] = ['error','You are not allowed this action in demo'];

                return redirect()->back()->withNotify($notify);
            }
        }
        return $next($request);
    }
}
