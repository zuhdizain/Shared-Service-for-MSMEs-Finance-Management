<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReport extends Model
{
    use HasFactory;
    
    protected $table = 'order_reports';

    protected $fillable = [
        'user_id', 'report', 'report_date',
    ];
}
