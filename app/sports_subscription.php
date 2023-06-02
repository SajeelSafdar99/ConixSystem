<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class sports_subscription extends Model
{
	use SoftDeletes;
use Userstamps;
	protected $table='sports_subscriptions';
     protected $fillable = ['code','desc', 'charges', 'status', 'deleted_at','created_by', 'updated_by', 'deleted_by', 'account'];
}
