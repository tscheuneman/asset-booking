<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Cas;
use App\Installer;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class InstallerController extends Controller
{
    public function index() {
        $installer = Installer::paginate(25);
        return view('admin.installers',
            [
                'installers' => $installer
            ]
        );
    }

    public function create() {
        return view('admin.installerCreate');
    }

    public function store() {
        $installer = new Installer();

        $this->validate(request(), [
            'username' => 'required|unique:installers',
            'email' => 'required|email',
            'company' => 'required',
        ]);

        $installer->username = request('username');
        $installer->email = request('email');
        $installer->company = request('company');
        $installer->password = Hash::make(request('username'));

        $installer->save();

        \Session::flash('flash_created', request('username') . ' has been created');
        return redirect('/admin/installers');
    }

    public function edit($id)
    {
        $installer = Installer::find($id);
        return view('admin.installerEdit',
            [
                'installer' => $installer
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'id' => 'exists:installers',
            'username' => 'required',
            'email' => 'required|email',
            'company' => 'required'
        ]);

        try {
            $installer = Installer::find($id);
            $installer->username = request('username');
            $installer->company = request('company');
            $installer->email = request('email');

            $installer->save();

            \Session::flash('flash_created', request('username') . ' has been edited');
            return redirect('/admin/installers');
        } catch (QueryException $e) {
            \Session::flash('flash_deleted', 'Error Editing Installer');
            return redirect('/admin/installers');
        }

    }

    public function destroy($id)
    {
        try {
            $installer = Installer::find($id);
            $user = $installer->username;
            $installer->delete();

            \Session::flash('flash_deleted', $user . ' has been deleted');
            return redirect('/admin/installers');
        } catch (QueryException $e) {
            \Session::flash('flash_deleted', 'Error Deleting Installer');
            return redirect('/admin/installers');
        }
    }
}
