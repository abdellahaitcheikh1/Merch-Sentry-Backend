<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//  TODO duplicer pour tous les types de utilisateures 
class historique_Operation_Admin extends Model
{
    use HasFactory;
    protected $fillable =[
        'IdAdmin',
        'TypeAction',

    ];
}
