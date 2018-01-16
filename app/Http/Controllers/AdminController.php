<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cas;
use App\Admin;

class AdminController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        Cas::authenticate();
        $user = Admin::getName(Cas::user());
        return view('admin.main',
            [
                'user' => $user
            ]
        );
    }

    public function store() {
        $admin = new Admin();

        $this->validate(request(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'asurite' => 'required|unique:admins'
        ]);

        $admin->first_name = request('first_name');
        $admin->last_name = request('last_name');
        $admin->email = request('email');
        $admin->asurite = request('asurite');

        $admin->save();
        return redirect('/admin/users');
    }

    public function show() {
        $users = Admin::get();
        return view('admin.users',
            [
                'users' => $users
            ]
        );
    }

    public function create() {
        return view('admin.usersCreate');
    }
}
