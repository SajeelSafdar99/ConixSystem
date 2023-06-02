<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class media extends Model
{
use SoftDeletes;
use Userstamps;
    protected $table='media';
    protected $fillable=['type','type_id','url', 'deleted_at','created_by', 'updated_by', 'deleted_by', 'trans_type', 'trans_type_id'];

}
