<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class event_bookingmenusub extends Model
{

use Userstamps;
    protected $fillable = ['booking_id','item_name', 'created_by', 'updated_by'];
}
