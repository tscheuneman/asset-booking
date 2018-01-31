<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cas;
use App\Installer;
use Illuminate\Support\Facades\Hash;

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
}
