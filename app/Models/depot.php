<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class depot extends Model
{
    use HasFactory;
    protected $connection = "mysql_second";

    protected $fillabel = [
        'IdDepot',
        'IdVille',
        'IsMagasin',
        'Reference',
        'NomDepot',
        'Adresse',
        'Tele',
        'Fax',
        'DateCreation',
        'DateModification',
        'Supprime'	,
        'Imprimante',

    ];
}
