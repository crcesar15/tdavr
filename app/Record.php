<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function Patient(){
        return $this->belongsTo(Patient::class);
    }
}
