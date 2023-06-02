<?php

namespace App;
use App\room_category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class room_category_charges extends Model
{
	use SoftDeletes;

use Userstamps;
    protected $fillable = ['room_category_id','room_id', 'charges', 'status','deleted_at','created_by', 'updated_by', 'deleted_by'];   
    public function roomtypes()
    {
        return $this->hasOne('App\room_category','id','room_category_id');
    }

  }
