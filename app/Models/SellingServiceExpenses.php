<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellingServiceExpenses extends Model
{
    use HasFactory;

    protected $table = 'selling_service_expenses';

    protected $fillable = [
        'user_id', 'month', 'adm_ecommerce', 'marketing_salary', 
        'marketing_operations', 'other_cost',
    ];
}
