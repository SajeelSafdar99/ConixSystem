<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class permissions extends Model
{
use Userstamps;
   protected $fillable = ['desc','created_by', 'updated_by'];
}
