<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class demande extends Model
{
    use HasFactory , Notifiable;
    public $timestamps = false;
    protected $fillable =[
        'nom',
        'email',
        'NomMagasin',
        'password',
        'adress',
        'tele',
        'type',
        'latitude',
        "longitude",
    ];
}
