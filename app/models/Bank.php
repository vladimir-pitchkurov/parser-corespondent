<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    public function bankId($title)
    {
        $title = trim($title);
        $result = $this->where('title', $title)->first();

        return !! $result ? $result->id : $this->insertGetId(['title' => $title]);
    }
}
