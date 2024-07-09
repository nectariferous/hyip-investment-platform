<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RedirectIfTenantUser
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
        $tenant = Route::current()->parameters()['tenant'];

        User::where('company_name', $tenant)->firstOrFail();
       
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return $next($request);
    }
}
