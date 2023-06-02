<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class memberSubscriptions extends Model
{
    use SoftDeletes;
use Userstamps;
    protected $fillable=['member_id','subscription_id','deleted_at','created_by', 'updated_by', 'deleted_by'];
    protected $dates=['created_at','updated_at'];
    public function member(){
       return $this->hasOne(membership::class,'id','member_id');
    }
    public function subscription()

    {
        return $this->hasOne(sports_subscription::class,'id','member_id');

    }
}
