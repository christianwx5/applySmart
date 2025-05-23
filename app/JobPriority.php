<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPriority extends Model
{
    //use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'value',
        'status'
    ];
}
