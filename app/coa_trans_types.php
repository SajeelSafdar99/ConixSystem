<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class coa_trans_types extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['name','type','mod_id','deleted_at','created_by', 'updated_by', 'deleted_by', 'cash_or_payment','details', 'table_name', 'cashrec_due', 'account', 'debit_or_credit'];   

  }
