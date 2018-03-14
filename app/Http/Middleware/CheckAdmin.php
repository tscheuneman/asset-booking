<?php

namespace App\Http\Middleware;

use Closure;
use Cas;
use App\Admin;

class CheckAdmin
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
        cas()->authenticate();
        if(cas()->isAuthenticated()) {
            $user = Admin::where('username', cas()->user())->first();
            if($user != null){
              return $next($request);
            }
            else {
              return redirect('/');
            }
        }
        else {
            return redirect('/');
        }

    }
}
