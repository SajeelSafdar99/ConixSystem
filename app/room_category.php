<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class room_category extends Model
{
	use SoftDeletes;
use Userstamps;

    protected $fillable = ['code','desc','status', 'deleted_at','created_by', 'updated_by', 'deleted_by'];
    public function chargesnull(){
    	  return $this->hasMany('App\room_category_charges','room_category_id');
    }
}
