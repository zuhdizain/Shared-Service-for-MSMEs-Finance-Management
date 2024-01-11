<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expired extends Model
{
    use HasFactory;
    protected $table = "expired";
    protected $guarded = [];
    public $timestamps = false;


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}