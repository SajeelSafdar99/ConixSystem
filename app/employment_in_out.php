<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class employment_in_out extends Model
{

use SoftDeletes;
use Userstamps;

    protected $table='employment_in_out';
    protected $fillable = ['employee_id','in','out','workingHours','created_by', 'updated_by','created_at', 'deleted_by'];
    protected $dates=['in','out'];
}
