<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commande extends Model
{
    use HasFactory;
    public $timestamps = false;
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
