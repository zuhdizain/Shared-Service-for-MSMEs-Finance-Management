<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = "employees";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function pickets()
    {
        return $this->hasMany(Pickets::class);
    }

    public function attendee()
    {
        return $this->hasMany(Attendee::class);
    }
}
