<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    
    protected $table = 'order_details';

    protected $fillable = [
        'order_id', 'customer_id', 'product_id', 'payment_proof',
        'product_quantity', 'total_price',
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
