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
        if(cas()->checkAuthentication()) {
            $user = Admin::where('username', cas()->user())->where('deleted_at', '=', null)->first();
            if($user != null){
              return $next($request);
            }
            else {
              return redirect('/');
            }
        }
        else {
            cas()->authenticate();
        }

    }
}
