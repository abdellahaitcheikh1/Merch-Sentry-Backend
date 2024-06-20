<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commercialQuepic extends Model
{
    use HasFactory;
    protected $connection = "mysql_Quepic";
    protected $fillable=[
        'nom',
        'prenom',
        'email',
        'password',
        'IdMagasin',
        'télephone',
        'cin',
        'credit',
        'vente',
        'annulé',
        'remboursé',
        'ville',
    ];
}
