<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commandeQuepic extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = "mysql_Quepic";
    protected $fillable=[
        'IdCommande',
        'IdDevis',
        'IdClient',
        'RefCommande',
        'NumCommande',
        'NomMagasin',
        'DateCreation',
        'DateModification',
        'DateCommande',
        'Statut',
        'Remarque',
        'Supprime',
        'IdMagasin',
        'IdUser',
        'IdExercice',
        'IsReported',
        'Ville',
        'Adresse',
        'TotalCommandeHT',
        'Statut',
        'TotalCommandeTTC',
        'IdRepresentant',
        'NbreLines',
        'EsCompte',
        'MontantAvecEsCompte',
        'RefCommandeClient',
        'IdSousClient',
        'IdExpediteur',
        'TotalRemise',
        'IdModeReglement',
        'RemiseGlobale',
        'RemiseSur',
        'TypeRemise',
        'NomClient',
    ];
}
