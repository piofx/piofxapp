<?php

namespace App\Models\UserManagement;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserManager extends Model
{
    use HasFactory,Sortable;
    protected $fillable = ['firstname','lastname','email','password','date_of_birth','address','address2','city','state','zip'];
    
    public $sortable = [
                        'firstname',
                        'created_at',];

    public function getRecords($item){
        return $this->where('firstname','LIKE',"%$item%");
    }
    public function getallRecords(){
        return $this->all();
    }
    
    public function getRecord($id){
        return $this->where("id", $id)->first();
    }
}
