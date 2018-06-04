<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminBaseController;
use App\User;
use App\Department;

class UserApprovalController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('active', '=', false)->paginate(config('globalSettings.entries-per-page'));
        return view('admin.user_approval.userapproval',
            [
                'users' => $users
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $dept = Department::get(['id', 'name']);
        return view('admin.user_approval.userEdit',
            [
                'user' => $user,
                'dept' => $dept
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', '=', $id)->first();

        if($user != null) {
            $user->active = true;
            $user->save();
            \Session::flash('flash_created',$user->first_name . '’s account has been approved');
            return redirect('/admin/user/approval');
        }
        else {
            \Session::flash('flash_deleted','Failed to approve account');
            return redirect('/admin/user/approval');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function users() {
        $users = User::where('active', '=', true)->paginate(config('globalSettings.entries-per-page'));
        return view('admin.user_approval.allusers',
            [
                'users' => $users
            ]
        );
    }

}
