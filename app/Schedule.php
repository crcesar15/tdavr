<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public $timestamps = false;
    
    public function Employee(){
        return $this->belongsTo(Employee::class);
    }

    public function Patient(){
        return $this->belongsTo(Patient::class);
    }
}
