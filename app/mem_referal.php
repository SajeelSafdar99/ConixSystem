<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mem_referal extends Model
{
	use SoftDeletes;
     protected $fillable = ['member_id','member_name','mem_no', 'relation', 'contact','deleted_at'];
}
