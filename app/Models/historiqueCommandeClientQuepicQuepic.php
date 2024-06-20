<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historiqueCommandeClientQuepicQuepic extends Model
{
    use HasFactory;
    protected $connection = "mysql_Quepic";
    public $timestamps = false;
    protected $fillable=[
        'IdClient',
        'NomClient',
        'Adresse',
        'Total',
        'Statut',
        'Date',
    ];
}
