<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardStat extends Model
{
    // Point this model directly to our MySQL View
    protected $table = 'vw_device_dashboard';
    
    // Views don't have standard primary keys or timestamps in the same way
    protected $primaryKey = 'id';
    public $timestamps = false;
}