<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class room_check_in extends Model
{
    protected $fillable = ['booking_id', 'check_in_date', 'check_in_time', 'status'];

     public function getCheckInDateAttribute($value)
    {
        return formatDateToShow($value);
    }
    public function getCheckOutDateAttribute($value)
    {
        return formatDateToShow($value);
    }
}
