<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function getAllCourses($params)
    {
        $likeDate = false;
        if($params){
            $likeDate = $params['date-get'];
            return $this->where('save_at', 'like', $likeDate.'%')->leftJoin('banks', 'bank_id', '=', 'banks.id')->get();
        }else return $this->leftJoin('banks', 'bank_id', '=', 'banks.id')->get();
    }

    public function existingDates()
    {
        return $this
            ->select('save_at', 'ru_date')
            ->groupBy('ru_date')
            ->orderBy('save_at', 'desc')
            ->get();
    }
}
