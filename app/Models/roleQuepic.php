<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roleQuepic extends Model
{
    use HasFactory;
    protected $connection = "mysql_Quepic";
    public $timestamps = false;
    protected $fillable=[
        'NomRole',
    ];
}
