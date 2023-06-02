<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\room_type;
use App\room_category_charges;
use Wildside\Userstamps\Userstamps;

class room extends Model
{
	use SoftDeletes;
    use Userstamps;
    protected $keyType = 'string';
    protected $fillable = ['code','room_no', 'room_type', 'status', 'deleted_at','created_by', 'updated_by', 'deleted_by', 'table_definition'];

    public function roomtypes()
    {
        return $this->hasOne('App\room_type','id','room_type');
    }

    public function categorywithchanges(){

    	return $this->hasMany('App\room_category_charges','room_id','id');
    }


public function visits(){
        return $this->hasMany('App\room_booking','room','id');
    }



}
