<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class event_menus_subs extends Model
{

use Userstamps;

    protected $fillable = ['menu_id','item_name', 'item_charges','created_by', 'updated_by'];
    function item(){
        return $this->hasOne('App\event_rate_category','id','item_name');
    }

}
