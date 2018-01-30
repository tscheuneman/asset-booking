<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cas;
class InstallerController extends Controller
{
    public function index() {
        return view('installer.main',
            [
                'user' => Cas::user(),
            ]
        );
    }
}
