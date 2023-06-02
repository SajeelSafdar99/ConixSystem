<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class room_check_out extends Model
{
     public function getCheckInDateAttribute($value)
    {
        return formatDateToShow($value);
    }
    public function getCheckOutDateAttribute($value)
    {
        return formatDateToShow($value);
    }
}
