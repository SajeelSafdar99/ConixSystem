<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class event_bookingaddonsub extends Model
{
use Userstamps;
    protected $fillable = ['booking_id','add_on_name', 'addon_bill_details', 'add_on_charges', 'addoncomplementary', 'created_by', 'updated_by'];
}
