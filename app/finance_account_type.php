<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class finance_account_type extends Model
{
    use SoftDeletes;

use Userstamps;

    protected $fillable = ['level_one','level_two', 'level_three','desc', 'type','status', 'deleted_at','created_by', 'updated_by', 'deleted_by', 'trans_type'];


    public function account_head()
    {
        return $this->hasOne('App\finance_account_head','id','desc');
    }

     public function accounttypes()
    {
        return $this->hasOne('App\finance_account_head','id','desc');
    }

    public function generalVoucherDocs(){
        return $this->hasMany('App\media','type_id')->where('type',84);
    }
}
