<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Cas;

class IndexController extends Controller
{
    public function index() {
        Cas::authenticate();
        $user = Customer::getName(Cas::user());
        return view('index.welcome',
            [
                'user' => $user
            ]
        );
    }
}
