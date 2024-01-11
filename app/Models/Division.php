<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $table = "divisions";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

    public function training()
    {
        return $this->hasMany(Training::class);
    }

    public function history()
    {
        return $this->hasMany(Histories::class);
    }

    public function pickets()
    {
        return $this->hasMany(Pickets::class);
    }

    public function attend()
    {
        return $this->hasMany(Attendee::class);
    }
}
