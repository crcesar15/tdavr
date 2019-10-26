<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    CONST ADMIN = 1;
    CONST EMPLOYEE = 2;
    CONST PATIENT = 3;

    public function User(){
        return $this->hasOne(User::class);
    }
}
