<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kotrec extends Model
{
    //
    protected $connection='sqlite';
    protected $table='kotrec';
    protected $fillable = ['order','category', 'kot_id','user', 'xprider'];
    public function sale(){

        return $this->hasMany('App\fnb_sale','category','id');
    }
}
