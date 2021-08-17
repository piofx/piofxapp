<?php

namespace App\Models\Mailer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mailer\MailCampaign;
use App\Models\Mailer\MailTemplate;
use App\Models\Core\Client;
class MailLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'agency_id',
        'client_id',
        'mail_template_id',
        'reference_id',
        'email',
        'scheduled_at',
        'app',
        'subject',
        'message',
        'status', 
    ];

    public function mail_template()
    {
        return $this->belongsTo(MailTemplate::class);
    }

    public function mail_campaign()
    {
        return $this->belongsTo(MailCampaign::class,'reference_id');
    }

    

}
