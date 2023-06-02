<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Mpdf\Tag\P;

class coa_transactions extends Model
{
    use SoftDeletes;
    use Userstamps;
    protected $table="coa_transactions";
    protected $fillable = ['id','debit_or_credit', 'trans_type', 'trans_type_id', 'unit','account','amount','payment_method', 'desc','date','is_active', 'deleted_at', 'created_by', 'updated_by','deleted_by'];

}
