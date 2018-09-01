<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{


    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
