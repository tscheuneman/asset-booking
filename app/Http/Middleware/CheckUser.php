<?php

namespace App\Http\Middleware;

use Closure;
use Cas;
use App\User;
use Illuminate\Support\Facades\Hash;

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
        if(Cas::authenticate()) {
            $user = User::where('username', Cas::user())->first();
            if($user === null){
                $thisUser = new User();
                $thisUser->username = Cas::user();
                $thisUser->email = Cas::user() . '@' . env('EMAIL_APPEND');
                $thisUser->password = Hash::make(Cas::user());
                $thisUser->save();
                return redirect('/');
            }
            else {
                return $next($request);
            }
        }
        else {
            return redirect('/invalid');
        }
    }
}
