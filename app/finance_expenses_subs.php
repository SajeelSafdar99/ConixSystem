<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class finance_expenses_subs extends Model
{
    use SoftDeletes;
	use Userstamps;

    protected $fillable = ['expense_id', 'person_id', 'type','expense_head', 'expense_payable','expense_details','charges','created_by', 'updated_by', 'deleted_by'];

}
