<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class payment_receipts_sub extends Model
{
    protected $fillable = ['payment_receipt_id','charges_type_id', 'bill_details', 'charges_amount'];

}
