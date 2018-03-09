<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Cas;
use App\User;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Cas::authenticate()) {
            $username = Cas::user();
            $user = User::where('username', $username)->first();
            if($user === null){
                $json = json_decode(file_get_contents(env('LDAP_API', 'https://google.com') . '?username=' . $username), true);

                $department = '';
                $first_name = '';
                $last_name = '';
                $email = $username . '@' . env('EMAIL_APPEND', 'google.com');
                if(isset($json[0]['department'][0])) {
                    $department = $json[0]['department'][0];
                }
                if(isset($json[0]['givenname'][0])) {
                    $first_name = $json[0]['givenname'][0];
                }
                if(isset($json[0]['sn'][0])) {
                    $last_name = $json[0]['sn'][0];
                }
                if(isset($json[0]['mail'][0])) {
                    $email = $json[0]['mail'][0];
                }

                return view('auth.register',
                    [
                        'user' => $username,
                        'department' => $department,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email
                    ]
                );
            } else {
                return redirect('/');
            }

        }
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


        $this->validate(request(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'username' => 'required|unique:users'
        ]);

        try {
            $user = new User();
            $user->first_name = request('first_name');
            $user->last_name = request('last_name');
            $user->email = request('email');
            $user->username = request('username');
            $user->department = request('department');
            $user->agency_org = request('agency_org');
            $user->password = Hash::make(str_random(8));

            $user->save();

            return redirect('/');

        } catch(Exception $e) {
            \Session::flash('flash_deleted', 'Error Creating User');
            return redirect('/admin/register');
        }

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
        //
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
        //
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
}
