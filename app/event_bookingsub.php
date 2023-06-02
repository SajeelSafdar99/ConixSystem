<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;


class event_bookingsub extends Model
{

use Userstamps;
    protected $fillable = ['booking_id','charges_type_id', 'bill_details', 'charges_amount', 'iscomplementary', 'created_by', 'updated_by'];
}
