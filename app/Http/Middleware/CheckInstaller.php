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
        if(cas()->checkAuthentication()) {
            $isInstaller = Installer::where('username', cas()->user())->first();
            if ($isInstaller !== null) {
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
