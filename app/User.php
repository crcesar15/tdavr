<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password','first_name', 'last_name', 'profile_photo', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Patient(){
        return $this->hasOne(Patient::class);
    }

    public function Employee(){
        return $this->hasOne(Employee::class);
    }

    public function Role(){
        return $this->belongsTo(Role::class);
    }
}
