<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_commande_client extends Model
{
    use HasFactory;
    protected $connection = "mysql_second";
    public $timestamps = false;
    protected $fillable=[
        'IdCommande',
        'RefArticle',
        'NomArticle',
        'quantity',
        'prix',
        'Statut',
    ];
}
