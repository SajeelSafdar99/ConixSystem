<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class bookingsub extends Model
{
    use Userstamps;
    use SoftDeletes;
    protected $fillable = ['booking_id','charges_type_id', 'bill_details', 'charges_amount', 'iscomplementary', 'created_by', 'updated_by', 'deleted_at', 'deleted_by'];
}
