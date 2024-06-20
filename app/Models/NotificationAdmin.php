<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationAdmin extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'Notification_Title',
        'Notification_Content',
        'Statut',
        'Date',
    ];
   
    
}
