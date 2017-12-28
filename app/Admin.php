<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public static function getName($asurite) {
        return static::select('first_name', 'last_name')->where('asurite', $asurite)->first();
    }
}
