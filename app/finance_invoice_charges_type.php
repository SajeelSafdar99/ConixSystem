<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;


class finance_invoice_charges_type extends Model
{
     use SoftDeletes;

use Userstamps;
    protected $fillable = ['type', 'charges', 'status', 'deleted_at','created_by', 'updated_by', 'deleted_by'];
}
