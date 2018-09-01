<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function getAllCourses()
    {
        return $this->leftJoin('banks', 'bank_id', '=', 'banks.id')->get();
    }
}
