<?php

namespace App\Http\Controllers\Admin;

use App\UserDepartment;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminBaseController;
use App\User;
use App\Department;
use Mockery\Exception;

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
        $user = User::with('departments.department')->where('id', $id)->first();
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

    public function saveUser(Request $request) {
        $user = User::where('username', $request->username)->first();

        if($user !== null) {
            try {
                $collectDept = $request->theDepartments;
                    $collectDeptArray = json_decode($collectDept);

                    $valid = true;
                foreach($collectDeptArray as $dept) {
                    if(!$this->checkDepartment($dept->id)) {
                        $valid = false;
                        break;
                    }
                }

                if($valid) {
                    $user->first_name = $request->first_name;
                    $user->last_name = $request->last_name;
                    $user->agency_org = $request->agency_org;
                    $user->email = $request->email;
                    $user->save();

                    foreach($collectDeptArray as $dept) {
                        if($this->checkIfUserDeptExists($user->id, $dept->id)) {
                            $department = new UserDepartment();
                            $department->user_id = $user->id;
                            $department->department_id = $dept->id;
                            $department->save();
                        }
                    }

                    \Session::flash('flash_created',$user->first_name . '’s account has been updated');
                    return redirect('/admin/user/users');
                }

                \Session::flash('flash_deleted','Failed to edit user');
                return redirect('/admin/user/users');
            } catch(Exception $e) {
                \Session::flash('flash_deleted','Failed to edit user');
                return redirect('/admin/user/users');
            }
        }
        \Session::flash('flash_deleted','Failed to edit user');
        return redirect('/admin/user/users');
    }

    private function checkDepartment($id) {
        $dept = Department::find($id);
        if($dept !== null) {
            return true;
        }
        return false;
    }


    private function checkIfUserDeptExists($user, $dept) {
        $dept = UserDepartment::where('user_id', $user)->where('department_id', $dept)->get();
        if(count($dept) < 1) {
            return true;
        }
        return false;
    }

}
