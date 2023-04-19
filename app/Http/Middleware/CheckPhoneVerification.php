<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPhoneVerification
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
        if(Auth::user()->phone_verified != STATUS_SUCCESS) {
            return redirect()->route('userProfile',['qr'=>'pvarification-tab'])->with('dismiss',__('Please verify your phone before trade'));
        }
        return $next($request);
    }
}
