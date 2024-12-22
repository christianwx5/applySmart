<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    // Añade esta línea para permitir la asignación masiva protected 
    protected $fillable = ['name', 'country', 'type', 'importance', 'status'];
}
