<?php

namespace App\Models\Mailer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mailer\MailLog;
use App\Models\Mailer\MailTemplate;

class MailCampaign extends Model
{
    use HasFactory;
    protected $fillable = [
        'agency_id',
        'client_id',
        'user_id',
        'mail_template_id',
        'name', 
        'description', 
        'emails',
        'scheduled_at',
        'status', 
        'timezone',
    ];
    public function mail_log()
    {
        return $this->belongsTo(MailLog::class);
        
    }

    public function mail_template()
    {
        return $this->belongsTo(MailTemplate::class);
    }
    
}
