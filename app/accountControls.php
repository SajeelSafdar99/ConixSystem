<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class accountControls extends Model
{
     use SoftDeletes;
    use Userstamps;

    protected $table='accounts_controls';
    protected $fillable=['name','desc','code','category_id','parent','deleted_at','created_by', 'updated_by', 'deleted_by', 'trans_type'];
   // public $timestamps=false;
}
