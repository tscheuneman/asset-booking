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
        $admin = Admin::where('username', '=', cas()->user())->first();
        View::share('admin', $admin);
    }
}
