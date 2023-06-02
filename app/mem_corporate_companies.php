<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class mem_corporate_companies extends Model
{
    use SoftDeletes;
    use Userstamps;
    protected $fillable = ['name','profile','address', 'city','contact','email', 'website', 'ntn', 'status','company_logo', 'deleted_at','created_by', 'updated_by', 'deleted_by'];
}
