<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mem_affiliation extends Model
{
	use SoftDeletes;
    protected $fillable = ['member_id','affiliation','name', 'period', 'other_club', 'details', 'political_affiliation', 'relative_a', 'relative_b', 'stayed_abroad', 'abroad_details', 'criminal', 'criminal_details', 'deleted_at'];
}
