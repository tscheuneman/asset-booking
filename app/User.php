<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Emadadly\LaravelUuid\Uuids;

class User extends Authenticatable
{
    use Uuids;
    public $incrementing = false;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function departments() {
        return $this->hasMany('App\UserDepartment', 'user_id');
    }

    public function scopeSearchUser($query, $key) {
        if ($key!='') {
            $query->where(function ($query) use ($key) {
                $query->where("first_name", "LIKE","%$key%")->orWhere("last_name", "LIKE", "%$key%")->orWhere("username", "LIKE", "%$key%");
            });
        }
        return $query;
    }

}
