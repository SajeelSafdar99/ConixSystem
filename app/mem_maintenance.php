<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mem_maintenance extends Model
{
    protected $fillable = ['member_id','name','membership_number', 'membership_fee', 'addi_mem_charges', 'addi_mem_remarks', 'mem_discount', 'mem_discount_remarks', 'total_fee', 'amount', 'addi_mt_charges', 'addi_mt_remarks', 'mt_discount', 'mt_discount_remarks', 'total_maintenance'];
}
