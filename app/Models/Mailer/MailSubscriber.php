<?php

namespace App\Models\Mailer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailSubscriber extends Model
{
    use HasFactory;
    protected $fillable = [
        'agency_id',
        'client_id',
        'email',
        'info', 
        'app',
        'valid_email',  
        'status',    
    ];

}
