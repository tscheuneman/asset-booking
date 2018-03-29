<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Cas;
use App\Admin;
class AdminBaseController extends Controller
{
    public function __construct()
    {
        if(cas()->checkAuthentication()) {
            $admin = Admin::where('username', '=', cas()->user())->first();
            View::share('admin', $admin);
        }
        else {
            cas()->authenticate();
        }
    }
}
