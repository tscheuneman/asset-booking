<?php

namespace App\Http\Middleware;

use Closure;
use Cas;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        if(!Auth::check()) {
            Cas::authenticate();
            $user = User::where('username', Cas::user())->first();
            if($user === null){
                return redirect('/register');
            }
            else {
                Auth::login($user);
                return $next($request);
            }
        }
        else {
            return redirect('/invalid');
        }
    }
}
