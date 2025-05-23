<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    // Agrega los atributos permitidos para asignación masiva
    protected $fillable = [
        'title', 
        'description', 
        'createdAt', 
        'updatedAt', 
        'Company', 
        'idCompany', 
        'status', 
        'idApplyStatus', 
        'idRanking', 
        'idMyChance', 
        'idPleasantness', 
        'idPriority'
    ];

    // Definir los nombres personalizados para las marcas de tiempo 
    const CREATED_AT = 'createdAt'; 
    const UPDATED_AT = 'updatedAt';
}
