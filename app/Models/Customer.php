<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'customer_name', 'customer_phone', 'customer_email', 'customer_address',
    ];

    public function orderDetail() {
        return $this->hasMany(OrderDetail::class, 'customer_id', 'id');
    }
}
