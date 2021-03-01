<?php

namespace App\Models\Loyalty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltySetting extends Model
{
    use HasFactory;

    protected $table = 'loyalty_settings';

    protected $fillable = ['agency_id', 'client_id', 'settings'];
}
