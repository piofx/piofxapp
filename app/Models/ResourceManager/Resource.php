<?php

namespace App\Models\ResourceManager;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory,Sortable;
    protected $fillable = ['title','file','description'];
    
    public $sortable = [
                        'title',
                        'description',
                        'created_at'];

    public function getRecords($item){
        return $this->where('title','LIKE',"%$item%");
    }
    public function getallRecords(){
        return $this->all();
    }
    
    public function getRecord($id){
        return $this->where("id", $id)->first();
    }


}
