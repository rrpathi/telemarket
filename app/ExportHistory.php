<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExportHistory extends Model
{
	public $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'customer_export_history';
}
