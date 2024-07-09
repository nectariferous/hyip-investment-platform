<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class SetSubDomainInEveryRoute
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
        $tenant = request()->route()->parameters['tenant'];

        $user = User::where('company_name',$tenant)->firstOrFail();
    
        Url::defaults(['tenant' => $tenant]);

        return $next($request);
        

    }
}
