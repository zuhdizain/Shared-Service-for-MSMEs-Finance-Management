<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentAsset extends Model
{
    use HasFactory;

    protected $table = 'current_assets';

    protected $fillable = [
        'user_id', 'month', 'cash', 'accounts_receivable',
        'supplies', 'other_current_assets',
    ];
}
