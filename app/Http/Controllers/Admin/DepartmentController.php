<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Department;

use App\Http\Controllers\AdminBaseController;

class DepartmentController extends AdminBaseController
{

    /**
     * Show all departments
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $department = Department::paginate(config('globalSettings.entries-per-page'));
        return view('admin.departments.department',
            [
                'depts' => $department
            ]
        );
    }

    /**
     * Show create dept page
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.departments.departmentCreate');
    }


    /**
     * Store new department
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $this->validate(request(), [
            'name' => 'required|string',
        ]);

        $dept = new Department();
            $dept->name = $request->name;
            $dept->save();
        \Session::flash('flash_created',$request->name . ' has been created');
        return redirect('/admin/departments');
    }
}
