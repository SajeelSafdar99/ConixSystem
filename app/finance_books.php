<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class finance_books extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['desc', 'status', 'deleted_at', 'created_by', 'updated_by', 'deleted_by', 'debit_or_credit'];
}
