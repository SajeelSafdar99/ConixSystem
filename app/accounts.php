<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class accounts extends Model
{
    use SoftDeletes;
    use Userstamps;

    protected $fillable=['code','name','status','desc','deleted_at','created_by', 'updated_by', 'deleted_by'];
    public function scopeLevel($query, $level=1){


      $level=$level-1;
     return   $query->whereRaw('LENGTH(code) - LENGTH(REPLACE(code, "-", ""))='.$level);
    }public function scopeLevelg($query, $level=1){
    $level=$level-1;

    return   $query->whereRaw('LENGTH(code) - LENGTH(REPLACE(code, "-", ""))='.$level);
    } public function scopePlevel($query, $level=1){
     return   $query->whereRaw('code like "'.$level.'%"');
    }
    public function scopeUnits($query){
        return $this->scopeLevel($query,1);
    }  public function scopeCostCenters($query){
        return $this->scopeLevel($query,2);
    }
}
