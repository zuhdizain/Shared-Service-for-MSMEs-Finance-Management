<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceSheet extends Model
{
    use HasFactory;

    protected $table = 'balance_sheets';

    protected $fillable = [
        'user_id', 'ca_id', 'nca_id', 'month', 
        'total_ca', 'total_nca', 'total_assets',
    ];
}
