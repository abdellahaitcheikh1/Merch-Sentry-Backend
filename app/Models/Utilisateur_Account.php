<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Utilisateur_Account extends Model

{
    use HasFactory , Notifiable;
    public $timestamps = false;
    protected $fillable= [
        'email',
        'password',
        'database_name',
        'Account_type',

        
    ];
}
