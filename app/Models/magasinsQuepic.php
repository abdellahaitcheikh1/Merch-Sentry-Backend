<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class magasinsQuepic extends Model
{
    use HasFactory;
    protected $connection = "mysql_Quepic";
    protected $fillabel = [
        'NomMagasin',
        'Nom_complet_propriétaire',
        'email',
        'password',
        'adresse de siège',
        'status',
        'rc',
        'patente',
        'ice',
    ];
}
