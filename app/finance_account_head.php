<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class finance_account_head extends Model
{
    use SoftDeletes;
use Userstamps;

    protected $fillable = ['level_one','level_two', 'level_three','desc','status', 'deleted_at','created_by', 'updated_by', 'deleted_by'];


     public function accounttypes()
    {
        return $this->hasMany('App\finance_account_type');
    }
}