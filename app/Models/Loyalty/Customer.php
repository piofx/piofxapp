<?php

namespace App\Models\Loyalty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Loyalty\Reward;
use Kyslik\ColumnSortable\Sortable;
use App\Models\User;

class Customer extends Model
{
    use HasFactory, Sortable;

    protected $fillable = ['agency_id', 'client_id', 'user_id', 'name', 'phone', 'email', 'address'];

    protected $sortable = ['name'];

    public function rewards(){
        return $this->hasMany(Reward::class);
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
