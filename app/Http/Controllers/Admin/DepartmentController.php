<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Department;

use App\Http\Controllers\AdminBaseController;

class DepartmentController extends AdminBaseController
{
    public function index() {
        $department = Department::paginate(config('globalSettings.entries-per-page'));
        return view('admin.departments.department',
            [
                'depts' => $department
            ]
        );
    }

    public function create() {
        return view('admin.departments.departmentCreate');
    }

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
