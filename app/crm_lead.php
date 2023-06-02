<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class crm_lead extends Model
{
	use SoftDeletes;

    use Userstamps;
    protected $fillable = ['name','email','contact','designation','company','company_number','status', 'deleted_at','created_by', 'updated_by', 'deleted_by', 'assigned_to', 'assigned_by', 'call_status', 'follow_up', 'call_time', 'next_visit', 'lead_date','city','source', 'reason','delete_comments'];


      public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
    
}