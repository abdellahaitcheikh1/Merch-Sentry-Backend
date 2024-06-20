<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rolzepart extends Model
{
    use HasFactory;

    protected $connection = "mysql_second";
    public $timestamps = false;
    protected $fillable=[
        'NomRole',
    ];
}
