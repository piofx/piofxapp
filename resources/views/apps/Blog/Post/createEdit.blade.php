<x-dynamic-component :component="$app->componentName">

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($stub == 'create')
    <form action="{{ route($app->module.'.store') }}" id="post_form" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); addTextarea();">
@else
    <form action="{{ route($app->module.'.update', $obj->id) }}" id="post_form" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); addTextarea();">
@endif
    <!-----begin second header------->
    <div class="row pt-3 d-flex justify-content-end">
        <div class="col-12 col-lg-8">
            <div class="d-block d-md-flex justify-content-between align-items-center bg-white rounded-lg shadow-sm p-5">
                <div class="d-flex align-items-center justify-content-between">
                    <label class="checkbox">
                        <input type="checkbox" name="status" @if($stub == 'update'){{$obj->status == '1' ? 'checked' : ''}}@endif/>
                        <span class="mr-2"></span>
                            Active
                    </label>
                    <button type="submit" name="publish" value="save_as_draft" class="btn btn-transparent-info ml-md-5">Save As Draft</button>
                    <button type="submit" name="publish" value="preview" class="btn btn-outline-primary ml-md-5">Preview</button>
                </div>
                <div class="my-3 my-lg-0 ml-lg-3">
                    <div class="input-group date">
                        <input type="text" class="form-control bg-white" readonly="readonly" name="published_at" value="@if($stub == 'update'){{$obj ? $obj->published_at : ''}}@endif" placeholder="Schedule" id="kt_datetimepicker_2" onclick="this.value=''"/>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="far fa-calendar-check"></i>
                            </span>
                        </div>
                    </div>
                </div>
                @if($stub=='update')
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{ $obj->id }}">
                @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-primary ml-lg-3" name="publish" value="now">{{ $stub == 'update' ? 'Update' : 'Publish Now'}}</button>
            </div>
        </div>
    </div>
    <!-----end second header--------->

    <!------------begin::Content------------->
    <div class="mt-5">
        <div class="row container m-0 p-0 my-5">
            <div class="col-12 col-lg-9 bg-white p-5 rounded-lg">
                <input type="text" id="title" onkeyup="createSlug()"
                    class="form-control p-0 display-3" style="border: none; background: transparent;"
                    name="title" value="@if($stub == 'update'){{$obj ? $obj->title : 'Title'}}@else{{ 'Type your title here' }}@endif"/>
                <div class="d-flex align-items-center justify-content-left">
                    <label class="m-0 text-muted">Slug:</label>
                    <input type="text" id="slug" style="border: none; background: transparent;"
                        class="form-control p-0 d-inline ml-3"
                        name="slug" value="@if($stub == 'update'){{$obj ? $obj->slug : ''}}@else{{ 'type-your-title-here' }}@endif"/>
                </div>
                <textarea type="text"
                    class="form-control border h-auto px-3 py-3 mb-3 font-size-h6"
                    name="excerpt" placeholder="Give a Description" style="min-height: 140px;"/>@if($stub == 'update'){{$obj ? $obj->excerpt : ''}}@endif</textarea>

                <!-- Content -->
                <textarea name="content" hidden id="post_content" rows=5></textarea>

                <textarea id="post_editor">{!! $obj->content !!}</textarea>

            </div>

            <!-- Right Column -->
            <div class="col-12 col-lg-3 mt-5 mt-lg-0 px-0 pl-lg-5">
                <div class="bg-white p-5 rounded-lg">
                    <!-- Featured -->
                    <div class="p-3 bg-white my-3 rounded-lg shadow-sm">
                        <label class="checkbox">
                            <input type="checkbox" name="featured" @if($stub == 'update'){{$obj->featured == 'on' ? 'checked' : ''}}@endif/>
                            <span class="mr-2"></span>
                                Featured Post
                        </label>
                    </div> 
                    <!-- End Featured -->
    
                    <!-- Public or Priovate -->
                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample6">
                        <div class="card border rounded-lg mt-5">
                            <div class="card-header" id="headingOne6">
                                <div class="card-title" data-toggle="collapse" data-target="#visibility">
                                    <i class="fas fa-eye"></i> Visilibity
                                </div>
                            </div>
                            <div id="visibility" class="collapse show" data-parent="#accordionExample6">
                                <div class="card-body">
                                    <!--begin::Form Group-->
                                     <div class="">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="visibility" id="public" value="public" onclick="showGroup()" @if($stub == 'update'){{$obj->visibility == 'public' ? 'checked' : ''}}@else {{ 'checked' }}@endif>
                                            <label class="form-check-label" for="inlineRadio1">Public</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="visibility" id="private" value="private" onclick="showGroup()" @if($stub == 'update'){{$obj->visibility == 'private' ? 'checked' : ''}}@endif>
                                            <label class="form-check-label" for="inlineRadio2">Private</label>
                                        </div>
                                     </div>
                                    <!--end::Form Group-->
                                    <textarea name="group" id="group" class="form-control bg-light mt-3" cols="30" rows="3" style="resize: none; display:@if($stub == 'update'){{$obj->visibility == 'private' ? 'block' : 'none'}}@else {{ 'none' }}@endif;" placeholder="Type in Comma Separated Group Names">@if($stub == 'update'){{$obj->group ? $obj->group : ''}}@endif</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Public or Private -->
                    

                    <div class="p-7 rounded border my-3 bg-white">
                        <h3 class="d-flex align-items-center mb-5">Featured Image</h3>
                        
                        <div id="featured_image" class="d-none @if($obj->image) {{ 'd-block' }} @else {{ 'd-none' }} @endif">
                            @if(!empty($obj->image) && strlen($obj->image) > 5 && Storage::disk('s3')->exists($obj->image))
                                <img src="{{ Storage::disk('s3')->url($obj->image) }}" class="img-fluid rounded">
                            @endif
                            <button type="button" class="btn btn-danger mt-3" id="delete_image" onclick="deleteImage()">Delete</button>
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

                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample6">
                        <div class="card border rounded-lg mt-5">
                            <div class="card-header" id="headingOne6">
                                <div class="card-title" data-toggle="collapse" data-target="#collapseOne1">
                                    <i class="fas fa-cookie"></i> Meta Data
                                </div>
                            </div>
                            <div id="collapseOne1" class="collapse show" data-parent="#accordionExample6">
                                <div class="card-body">
                                    <!--begin::Form Group-->
                                    <div class="form-group m-0">
                                        <input type="text"
                                            class="form-control h-auto bg-light border mb-2 p-3 rounded-md font-size-h6"
                                            name="meta_title" placeholder="Title" value="@if($stub == 'update'){{$obj ? $obj->meta_title : ''}}@endif"/>
                                        <input type="text"
                                            class="form-control h-auto border bg-light p-3 rounded-md font-size-h6"
                                            name="meta_description" placeholder="Description" value="@if($stub == 'update'){{$obj ? $obj->meta_description : ''}}@endif"/>
                                    </div>
                                    <!--end::Form Group-->
                                </div>
                            </div>
                        </div>
                        <div class="card border rounded-lg">
                            <div class="card-header" id="headingOne6">
                                <div class="card-title " data-toggle="collapse" data-target="#collapseOne2">
                                    <i class="fas fa-stream"></i> Categories
                                </div>
                            </div>
                            <div id="collapseOne2" class="collapse show" data-parent="#accordionExample6">
                                <div class="card-body">
                                    <select class="form-control select2" id="kt_select2_1" name="category_id">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if($stub == 'update') @if($obj->category_id == $category->id) {{ 'selected' }} @endif @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card border rounded-lg">
                            <div class="card-header" id="headingOne6">
                                <div class="card-title" data-toggle="collapse" data-target="#collapseOne3">
                                    <i class="fas fa-tags"></i> Tags
                                </div>
                            </div>
                            <div id="collapseOne3" class="collapse show" data-parent="#accordionExample6">
                                <div class="card-body">
                                    <!------begin Tags------>
                                    <select class="form-control select2" style="min-height: 2.5rem;" id="kt_select2_11" name="tag_ids[]" multiple="multiple" placeholder="Add a Tag">

                                        @php
                                            $tag_ids = [];
                                            foreach($obj->tags as $tag){
                                                array_push($tag_ids, $tag->id);
                                            }
                                        @endphp

                                        @foreach($tags as $tag)
                                                <option value="{{ $tag->id }}" @if($stub == "update") @if(in_array($tag->id, $tag_ids)) {{ "selected" }} @endif @endif>{{ $tag->name }}</option>
                                        @endforeach
                                        
                                    </select>
                                    <!------end Tags-------->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- end::Right Column -->
        </div>
    </div>
    <!--end::Content-->

</form>

</x-dynamic-component>