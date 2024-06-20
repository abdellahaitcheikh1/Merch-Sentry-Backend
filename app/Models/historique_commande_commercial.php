<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historique_commande_commercial extends Model
{
    use HasFactory;
    protected $connection = "mysql_second";
    public $timestamps = false;
    protected $fillable=[
        'IdCommercial',
        'NomCommercial',
        'Adresse',
        'Total',
        'Statut',
        'Date',
    ];
}
