<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class room_type extends Model
{
	use SoftDeletes;
use Userstamps;
    protected $fillable = ['code','desc','status', 'deleted_at','created_by', 'updated_by', 'deleted_by', 'account'];
    public function rooms(){
    	  return $this->hasMany('App\room','room_type');
    }
}
