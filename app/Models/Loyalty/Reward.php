<?php

namespace App\Models\Loyalty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Loyalty\Customer;
use App\Models\User;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = ['agency_id', 'client_id', 'user_id', 'customer_id', 'amount', 'description', 'credits', 'redeem'];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    /**
	 * Get the user that owns the page.
	 *
	 */
	public function user()
	{
	    return $this->belongsTo(User::class);
	}
}
