<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\event_menus_subs;
use Wildside\Userstamps\Userstamps;

class event_menu extends Model
{
    use SoftDeletes;

use Userstamps;
    protected $fillable = ['menu_name','menu_type', 'total','status', 'deleted_at','created_by', 'updated_by', 'deleted_by'];

     public function menus(){

        return $this->hasMany('App\event_menus_subs','menu_id','id');
    }

}
