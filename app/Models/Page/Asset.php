<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Client;
use App\Models\Page\Module;
use App\Models\Page\Theme;
use App\Models\Page\Page;
use Illuminate\Support\Facades\Storage;

class Asset extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'path',
        'type',
        'user_id',
        'client_id',
        'agency_id',
        'theme_id',
        'status',
    ];

       /**
     * Get the list of records from database
     *
     * @var array
     */
    public function getRecords($item,$limit,$theme_id){
        $filter = request()->get('filter');

        if($filter)
    	   return $this->where('name','LIKE',"%{$item}%")
                    ->where('type',$filter)
                    ->where('client_id',request()->get('client.id'))
                    ->where('theme_id',$theme_id)
                    ->orderBy('created_at','desc')
                    ->paginate($limit);
        else
            return $this->where('name','LIKE',"%{$item}%")
                    ->where('client_id',request()->get('client.id'))
                    ->where('theme_id',$theme_id)
                    ->orderBy('created_at','desc')
                    ->paginate($limit);

    }
    

    /**
     * Upload single file
     *
     */

    public function uploadFile($theme_id,$request){

        
    	/* If image is given upload and store path */
    	if(isset($request->all()['file'])){

    		$file      = $request->all()['file'];
            $fname = $file->getClientOriginalName();
    		$extension = strtolower($file->getClientOriginalExtension());

    		if(in_array($extension, ['jpg','jpeg','png','gif','svg','webp']))
    			$type = 'images';
    		else if(in_array($extension, ['otf','','ttf','fnt','eot','woff','woff2']))
    			$type = 'images';
    		else
    			$type = $extension;
    			
    		$filename = 'file_'.$fname;

    		$path = Storage::disk('public')->putFileAs('themes/'.$theme_id, $request->file('file'),$filename,'public');

    		$request->merge(['path' => $path]);
            $request->merge(['slug' => $fname]);
    		$request->merge(['type' => $type]);
    	}


    }

    /**
     * Upload multiple files
     *
     */

    public function uploadMultipleFiles($theme_id,$request){

        /* If image is given upload and store path */
        if(isset($request->all()['files'])){
            $files      = $request->all()['files'];

            foreach($files as $k=>$file){
                $extension = strtolower($file->getClientOriginalExtension());

                $fname = $file->getClientOriginalName();

                if(in_array($extension, ['jpg','jpeg','png','gif','svg','webp']))
                    $type = 'images';
                else if(in_array($extension, ['otf','','ttf','fnt','eot','woff','woff2']))
                    $type = 'images';
                else
                    $type = $extension;
                    
                $filename = 'file_'.$fname;

                $path = Storage::disk('public')->putFileAs('themes/'.$theme_id, $request->file('files')[$k],$filename,'public');

                $request->merge(['path' => $path]);
                $request->merge(['type' => $type]);

                $asset = new Asset;
                $asset->name = $fname;
                $asset->slug = $fname;
                $asset->path = $path;
                $asset->type= $type;
                $asset->user_id = \Auth::user()->id;
                $asset->client_id = $request->get('client_id');
                $asset->agency_id = $request->get('agency_id');
                $asset->theme_id = $theme_id;
                $asset->status = 1;
                $asset->save();

            }
        }


    }

    /**
	 * Get the user that owns the page.
	 *
	 */
	public function user()
	{
	    return $this->belongsTo(User::class);
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
