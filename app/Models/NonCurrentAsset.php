<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonCurrentAsset extends Model
{
    use HasFactory;

    protected $table = 'non_current_assets';

    protected $fillable = [
        'user_id', 'month', 'fixed_assets', 'depreciation',
    ];
}
