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
            'username' => 'required|unique:admins'
        ]);

        $admin->first_name = request('first_name');
        $admin->last_name = request('last_name');
        $admin->email = request('email');
        $admin->username = request('username');

        $admin->save();

        \Session::flash('flash_created', request('username') . ' has been created');
        return redirect('/admin/users');
    }

    public function show() {
        $users = Admin::paginate(50);
        return view('admin.users',
            [
                'users' => $users
            ]
        );
    }

    public function create() {
        return view('admin.usersCreate');
    }

    public function edit($id)
    {
        $user = Admin::find($id);
        return view('admin.usersEdit',
            [
                'user' => $user
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        $this->validate(request(), [
            'id' => 'exists:admins',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'username' => 'required|exists:admins'
        ]);

        $admin->first_name = request('first_name');
        $admin->last_name = request('last_name');
        $admin->email = request('email');
        $admin->updated_at = date('Y-m-d H:i:s');

        $admin->save();

        \Session::flash('flash_created',request('username') . ' has been edited');
        return redirect('/admin/users');
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
            $user = $admin->username;
        $admin->delete();

        \Session::flash('flash_deleted',$user . ' has been deleted');
        return redirect('/admin/users');
    }
}
