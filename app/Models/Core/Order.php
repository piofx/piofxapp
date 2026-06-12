<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'agency_id',
        'user_id',
        'order_id',
        'txn_id',
        'product',
        'payment_mode',
        'bank_txn_id',
        'bank_name',
        'txn_amount',
        'expiry',
        'redirect_url',
        'data',
        'status',
    ];

}
