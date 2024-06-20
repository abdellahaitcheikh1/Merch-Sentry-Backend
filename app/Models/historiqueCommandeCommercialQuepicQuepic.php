<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historiqueCommandeCommercialQuepicQuepic extends Model
{
    use HasFactory;
    protected $connection = "mysql_Quepic";
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
