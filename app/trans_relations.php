<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class trans_relations extends Model
{
    //
    use SoftDeletes; 
    use Userstamps;
    protected $table='trans_relations';
    protected $fillable=['invoice','receipt', 'created_by', 'updated_by', 'account', 'deleted_at', 'deleted_by'];
    public function invoiceDetails(){
       return $this->belongsTo('App\transactions','id','invoice');
    }
   /* public function receiptDetails(){
       return $this->belongsTo('App\transactions','receipt','id');
    }*/  public function receiptSum(){
       return $this->belongsTo('App\transactions','receipt','id')->get()->sum('trans_amount');
    }
}
