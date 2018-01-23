<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cas;
use App\Admin;
use App\Asset;
use App\Category;
use App\Building;
use App\Region;
use App\User;
use Mockery\Exception;

class AdminController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $user = Admin::getName(Cas::user());
        $assetCount = Asset::count();
        $categoryCount = Category::count();
        $buildingCount = Building::count();
        $regionCount = Region::count();
        $userCount = User::count();

        return view('admin.main',
            [
                'user' => $user,
                'assetCount' => $assetCount,
                'categoryCount' => $categoryCount,
                'buildingCount' => $buildingCount,
                'regionCount' => $regionCount,
                'userCount' => $userCount
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
        $users = Admin::paginate(25);
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
        $this->validate(request(), [
            'id' => 'exists:admins',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'username' => 'required|exists:admins'
        ]);

        try {
            $admin = Admin::find($id);
            $admin->first_name = request('first_name');
            $admin->last_name = request('last_name');
            $admin->email = request('email');
            $admin->updated_at = date('Y-m-d H:i:s');

            $admin->save();

            \Session::flash('flash_created', request('username') . ' has been edited');
            return redirect('/admin/users');
        } catch (QueryException $e) {
            \Session::flash('flash_deleted', 'Error Editing Admin');
            return redirect('/admin/users');
        }

    }

    public function destroy($id)
    {
        try {
            $admin = Admin::find($id);
            $user = $admin->username;
            $admin->delete();

            \Session::flash('flash_deleted', $user . ' has been deleted');
            return redirect('/admin/users');
        } catch (QueryException $e) {
            \Session::flash('flash_deleted', 'Error Deleting Admin');
            return redirect('/admin/users');
        }
    }
}
