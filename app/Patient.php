<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'date_of_birth', 'contact_number', 'responsible_name','user_id'
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Records(){
        return $this->hasMany(Record::class);
    }

    public function Employees(){
        return $this->hasMany(Employee::class);
    }

    public function Schedules(){
        return $this->hasMany(Schedule::class);
    }
}
