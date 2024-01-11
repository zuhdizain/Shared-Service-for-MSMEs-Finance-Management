<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnForm extends Model
{
    use HasFactory;
    
    protected $table = 'return_forms';

    protected $fillable = [
        'order_status_id', 'isi_form', 'return_status',
    ];

    public function orderStatus() {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }
}
