<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_discount_card extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['type','name', 'customer_id', 'card_number', 'discount_amount', 'discount_percentage', 'card_issue_date', 'card_expiry_date', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];
}
