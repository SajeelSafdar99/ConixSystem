<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class coa_accounts_control extends Model
{
    use SoftDeletes;
    use Userstamps;

    protected $table='coa_accounts_controls';
    protected $fillable=['name','desc','code','category_id','parent','deleted_at','created_by', 'updated_by', 'deleted_by', 'trans_type', 'def', 'show','remarks','cost_center'];
   // public $timestamps=false;

    public function generalVoucherDocs(){
        return $this->hasMany('App\media','type_id')->where('type',84);
    }
}
