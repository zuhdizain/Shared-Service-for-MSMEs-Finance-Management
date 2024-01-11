<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralAdminCost extends Model
{
    use HasFactory;

    protected $table = 'general_admin_costs';

    protected $fillable = [
        'user_id', 'month', 'salaries_and_allowances', 'electricity_and_water', 
        'transportation', 'communication', 'office_stationery', 'consultant',
        'cleanliness_and_security', 'maintenance_and_renovation', 'depreciation',
        'tax', 'other_cost',
    ];
}
