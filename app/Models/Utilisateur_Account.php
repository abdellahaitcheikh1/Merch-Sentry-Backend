<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur_Account extends Model

{
    use HasFactory;
    public $timestamps = false;
    
    protected $fillable= [
        'email',
        'password',
        'database_name',
        'Account_type',

        
    ];
}
