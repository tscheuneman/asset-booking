<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Admin;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->primary('id');
            $table->string('username')->nullable(false);
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('picture');
            $table->dateTime('deleted_at')->nullable(true)->default(null);
            $table->timestamps();
        });

        //Create default admin user
        $admin = new Admin();
            $admin->username = env('INITAL_ADMIN_USER', 'admin');
            $admin->first_name = "FirstName";
            $admin->last_name = "LastName";
            $admin->email = env('INITAL_ADMIN_USER', 'admin') . '@' . env('EMAIL_APPEND', 'google.com');
            $admin->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
