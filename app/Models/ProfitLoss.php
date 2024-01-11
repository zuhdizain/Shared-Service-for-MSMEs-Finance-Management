<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitLoss extends Model
{
    use HasFactory;

    protected $table = 'profit_losses';

    protected $fillable = [
        'user_id', 'cogs_id', 'sse_id', 'gac_id', 'month', 
        'total_sales', 'total_hpp', 'total_sse', 'total_gac',
    ];
}
