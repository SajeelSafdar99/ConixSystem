<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_user_shifts extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['user_id','pos_location','in_out','deleted_at', 'created_by', 'updated_by', 'deleted_by'];



   /* public function posname(){
         return $this->belongsTo('App\fnb_pos_location','pos_location');
    }*/
}
