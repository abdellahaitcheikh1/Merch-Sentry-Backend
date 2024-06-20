<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notificationzenpart extends Model
{
    use HasFactory;
    protected $connection = "mysql_second";
    protected $table = 'notification';
    public $timestamps = false;
    protected $fillable=[
        'IdRole',
        'Notification_Title',
        'Notification_Content',
        'Statut',
        'Date',
    ];
}
