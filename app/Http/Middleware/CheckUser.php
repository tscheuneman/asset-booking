<?php

namespace App\Http\Middleware;

use Closure;
use Cas;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Setting;

class CheckUser
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
        $useCas = filter_var(config('globalSettings.enable-cas'), FILTER_VALIDATE_BOOLEAN);
        if($useCas) {
            if(cas()->checkAuthentication()) {
                $user = User::where('username', cas()->user())->first();
                if($user === null){
                    return redirect('/register');
                }
                else {
                    Auth::login($user);
                    return $next($request);
                }
            }
            else {
                cas()->authenticate();
            }
        }
        else {
            if (Auth::check()) {
                $user = User::where('username', Auth::id())->first();
                if($user === null){
                    return redirect('/login');
                }
                else {
                    Auth::login($user);
                    return $next($request);
                }
            }
            else {
                return redirect('/login');
            }
        }
    }
}
