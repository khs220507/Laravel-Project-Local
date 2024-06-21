<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'temperature', 
        'humidity', 
        'base_date', 
        'base_time'
    ];
}
