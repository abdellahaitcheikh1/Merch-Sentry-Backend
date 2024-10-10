<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class client_Cica extends Model
{
    use HasFactory;
    protected $fillable = [
        'idUtilisateureClient',
        'IdFamilleClient',
        'RefClt'	,
        'NomClient',
        'PrenomClient',
        'IdMagasin',	
        'Description',	
        'NumTele'	,
        'NumFax',	
        'EmailClient',	
        'PasswordClient',	
        'SiteWebClient',	
        'ContactClient',	
        'Adresse'	,
        'DateCreation'	,
        'DateModification'	,
        'Supprime'	,
        'isBloque'	,
        'AddresseFacturation',	
        'Banque'	,
        'Agence',	
        'Compte',	
        'Debit'	,
        'Credit',	
        'SoldeMaximum'	,
        'Ville'	,
        'ProgID',	
        'NumClient',	
        'IdRepresentant',	
        'AssuranceGarantie'	,
        'Patente'	,
        'I_F'	,
        'IdDevise',	
        'IsSousClient',	
        'IdSecteur'	,
        'IdVille'	,
        'IdTypePrix',	
        'IsEnCompte',	
        'IsRemiseGlobale',	
        'RemiseGlobale',	
        'NbrCopieFacture',	
        'NbrCopieBL'	,
        'CodeComptableClient',	
        'IsProspect',	
        'ICE'	,
        'IdTypeReglement'	,
        'PrintRemarque'	,
        'Solde',
];
}
