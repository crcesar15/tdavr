<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'profession', 'phone', 'email','user_id'
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Schedules(){
        return $this->hasMany(Schedule::class);
    }
}
