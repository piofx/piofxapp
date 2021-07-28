<x-dynamic-component :component="$app->componentName">
  <div class="container my-5 p-5 bg-white rounded-lg shadow-sm">
    @if($stub == "create")
    <form method="POST" action="{{ route($app->module.'.store') }}">
    @else
    <form method="POST" action="{{ route($app->module.'.update', $obj->id) }}">
    @endif
      @csrf
      <h2 class="text-center font-weight-bolder text-primary py-2">Create a Category</h2>
      <div class="my-3">
        <h5>Name:</h5>
        <input class="form-control" name="name" id="title" onkeyup="createSlug()" type="text" value="@if($stub == 'update'){{ $obj ? $obj->name : '' }}@endif">
        <h5 class="mt-3">Slug:</h5>
        <input class="form-control" name="slug" id="slug" type="text" value="@if($stub == 'update'){{ $obj ? $obj->slug : '' }}@endif">
        <h5 class="mt-3">Meta Title:</h5> 
        <input class="form-control" type="text" name="meta_title" value="@if($stub == 'update'){{ $obj ? $obj->meta_title : '' }}@endif">
        <h5 class="mt-3">Meta Description:</h5> 
        <input class="form-control" type="text" name="meta_description" value="@if($stub == 'update'){{ $obj ? $obj->meta_description : '' }}@endif">
        <!-- Dropzone -->
        <div class="border rounded-lg p-5 my-5 bg-white">
            <h3 class="d-flex align-items-center mb-5">Featured Image</h3>
                        
            <div id="featured_image" class="d-none @if($obj->image) {{ 'd-block' }} @else {{ 'd-none' }} @endif">
                @if(!empty($obj->image) && strlen($obj->image) > 5)
                    @if(Storage::disk('s3')->exists($obj->image))
                        <img src="{{ Storage::disk('s3')->url($obj->image) }}" class="img-fluid d-block">
                    @endif
                    <button type="button" class="btn btn-danger mt-3" id="delete_image" onclick="deleteImage()">Delete</button>
                @endif
            </div>

            <div id="dropzone" class="d-none @if($obj->image) {{ 'd-none' }} @else {{ 'd-block' }} @endif">
                <div class="card card-custom m-0 gutter-b">
                    <div class="dropzone dropzone-default bg-light" id="kt_dropzone_1">
                        <div class="dropzone-msg dz-message needsclick">
                            <img src="{{ asset('img/upload.png') }}" class="img-fluid w-50">
                            <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                        </div>
                    </div>
                    <input type="hidden" id="dropzone_url" value="{{ url('/') }}/admin/dropzone">
                    <input type="hidden" class="_token" name="_token" value="{{ csrf_token() }}">
                </div>
            </div>
            
            <input type="hidden" id="image_url" name="image" value="@if($stub == 'update'){{$obj ? $obj->image : ''}}@endif">
        </div>
        <!-- End Dropzone -->
        @if($stub=='update')
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="{{ $obj->id }}">
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        @else
            <button type="submit" class="btn btn-primary mt-3">Create</button>
        @endif
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
    </form>
  </div>
</x-dynamic-component>