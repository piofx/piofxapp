<?php

namespace App\Models\Mailer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mailer\MailLog;
use App\Models\Mailer\MailCampaign;

class MailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'client_id',
        'user_id',
        'name', 
        'slug', 
        'subject',
        'message',
        'status', 
    ];

    
    public function mail_logs()
    {
        return $this->hasMany(MailLog::class);
    }

    public function mail_campaigns()
    {
        return $this->hasMany(MailCampaign::class);
    }

}