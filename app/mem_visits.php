<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class mem_visits extends Model
{

use Userstamps;
    protected $table='mem_visits';
    protected $fillable=['type','type_id','location','created_by', 'updated_by'];
   public function member(){
       $this->belongsTo('app\membership','type_id','id')->where('type',0);
   }  public function family(){
       $this->belongsTo('app\mem_family','type_id','id')->where('type',1);
   }
}
