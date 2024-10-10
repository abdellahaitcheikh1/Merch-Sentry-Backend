<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailCommande extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    protected $table = 'detail_commandes';
    // public $timestamps = false;
    protected $fillable=[
        'idCommande',
        'RefArticle',
        'NomArticle',
        'quantity',
        'prix',
        'Statut',
    ];
}
