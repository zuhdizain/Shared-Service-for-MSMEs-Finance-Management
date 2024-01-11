<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostOfGoodsSold extends Model
{
    use HasFactory;

    protected $table = 'cost_of_goods_solds';

    protected $fillable = [
        'user_id', 'month', 'raw_material', 'manpower', 'factory_overhead',
    ];
}
