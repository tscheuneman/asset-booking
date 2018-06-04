<?php

use Illuminate\Database\Seeder;
use App\Admin;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create default admin user
        $admin = new Admin();
        $admin->username = env('INITAL_ADMIN_USER', 'admin');
        $admin->first_name = "FirstName";
        $admin->last_name = "LastName";
        $admin->email = env('INITAL_ADMIN_USER', 'admin') . '@' . env('EMAIL_APPEND', 'google.com');
        $admin->save();
    }
}
