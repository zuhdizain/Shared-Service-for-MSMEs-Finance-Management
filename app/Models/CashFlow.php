<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;

    protected $table = 'cash_flows';

    protected $fillable = [
        'user_id', 'ci_id', 'cogs_id', 'sse_id', 'gac_id', 'month', 
        'sales', 'total_cogs', 'total_sse', 'total_gac',
    ];
}
