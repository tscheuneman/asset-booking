<?php

namespace App\Http\Middleware;

use Closure;
use App\Admin;
use App\Installer;
use Cas;
use Auth;
class CheckInstaller
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
            $isAdmin = Admin::where('username', Cas::user())->first();
            $isInstaller = Installer::where('username', Cas::user())->first();
            if($isAdmin !== null){
                return $next($request);
            }
            elseif ($isInstaller !== null) {
                return $next($request);
            }
            else {
                return redirect('/error');
            }
        }
        else {
            return redirect('/error');
        }

    }
}
