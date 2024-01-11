<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class IsHR
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ((Auth::user() &&  Auth::user()->position == 'Staff Human Resource') || Auth::user()->authorization_level == 2) {
                return $next($request);
        }

        return redirect()->route('login')->with('loginError', 'HR Only!'); 
    }
}