<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Contact extends Model
{
    use HasFactory,Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'message',
        'comment',
        'client_id',
        'agency_id',
        'status',
    ];

    public $sortable = ['name',
                        'email',
                        'created_at'];

     /**
     * Get the list of records from database
     *
     * @var array
     */
    public function getRecords($item,$limit,$user){

    	if($user->isRole('superadmin'))
        	return $this->sortable()->where('name','LIKE',"%{$item}%")
        			->where('client_id',$user->client_id)
        			
                    ->orderBy('created_at','desc')
                    
                    ->paginate($limit);
        else
        	return $this->sortable()->where('name','LIKE',"%{$item}%")
        			
                    ->orderBy('created_at','desc')
                    
                    ->paginate($limit);

    }

    /**
	 * Get the client that owns the page.
	 *
	 */
	public function client()
	{
	    return $this->belongsTo(Client::class);
	}
}

