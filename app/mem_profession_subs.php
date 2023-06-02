<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class mem_profession_subs extends Model
{
    use Userstamps;
    use SoftDeletes;
    protected $fillable = ['profession_id', 'club_name', 'club_mem_no','created_by', 'updated_by', 'deleted_at', 'deleted_by'];

}
