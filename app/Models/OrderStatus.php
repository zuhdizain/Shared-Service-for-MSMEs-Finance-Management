<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    
    protected $table = 'order_statuses';

    protected $fillable = [
        'order_id', 'order_status',
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function returnForm() {
        return $this->hasOne(ReturnForm::class, 'order_status_id', 'id');
    }
}
