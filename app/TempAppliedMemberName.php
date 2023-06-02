<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class TempAppliedMemberName extends Model
{
    use Userstamps;
    
    protected $table = 'temp_applied_member_name';
    protected $fillable = ['sale_id','person_name'];

}
