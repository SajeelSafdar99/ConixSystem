<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class SalesTermsandConditions extends Model
{
    use SoftDeletes;
    use Userstamps;
    protected $fillable = ['terms_and_conditions', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];

    
}
