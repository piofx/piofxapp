<x-dynamic-component :component="$app->componentName">

@php
    $tag_ids = [];
    foreach($obj->tags as $tag){
        array_push($tag_ids, $tag->id);
    }

    $selected_tags = array();
    foreach($tags as $tag){
        if(in_array($tag->id, $tag_ids)){
            array_push($selected_tags, $tag->name);
        }
    }

    $title_keywords = array();
    $content_keywords = array();
    $meta_title_keywords = array();
    $meta_description_keywords = array();

    foreach($selected_tags as $tag){
        $title = strtolower($obj->title);
        $content = strtolower(strip_tags($obj->content));
        $meta_title = strtolower($obj->meta_title);
        $meta_description = strtolower($obj->meta_description);
        $tag = strtolower($tag);

        if(strpos($title, $tag)){
            $title_keywords[$tag] = substr_count($title, $tag); 
        }
        if(strpos($content, $tag)){
            $content_keywords[$tag] = substr_count($content, $tag); 
        }
        if(strpos($meta_title, $tag)){
            $meta_title_keywords[$tag] = substr_count($meta_title, $tag); 
        }
        if(strpos($meta_description, $tag)){
            $meta_description_keywords[$tag] = substr_count($meta_description, $tag); 
        }
    }

    if(!empty($obj->content)){
        $content_words = str_word_count(strip_tags(str_replace('<', ' <', $obj->content)));
    }
    if(!empty($obj->title)){
        $title_characters = strlen($obj->title);
    }

    $meta_description = '';
    if(!empty($obj->meta_description)){
        $meta_description = strlen($obj->meta_description);
    }

@endphp

    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
        <li class="breadcrumb-item">
            <a href="/admin" class="text-muted text-decoration-none">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/admin/blog"  class="text-muted text-decoration-none">{{ ucfirst($app->app) }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/admin/blog"  class="text-muted text-decoration-none">{{ ucfirst($app->module) }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#"  class="text-muted text-decoration-none">Create/Edit</a>
        </li>
    </ul>
    <!--end::Breadcrumb-->

@if($errors->any())
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
    <form action="{{ route($app->module.'.store') }}" id="post_form" method="POST" enctype="multipart/form-data" onsubmit="blogPostSubmit(this, event);">
@else
    <form action="{{ route($app->module.'.update', $obj->id) }}" id="post_form" method="POST" enctype="multipart/form-data" onsubmit="blogPostSubmit(this, event);">
@endif
    <!-----begin second header------->
    <div class="row pt-3 d-flex justify-content-end">
        <div class="col-12 col-lg-8">
            <div class="d-block d-md-flex justify-content-between align-items-center bg-white rounded-lg shadow-sm p-5">
                <div class="d-flex align-items-center justify-content-between">
                    <label class="checkbox">
                        <input type="checkbox" name="status" @if($stub == 'update'){{$obj->status == '1' ? 'checked' : null }}@endif/>
                        <span class="mr-2"></span>
                            Active
                    </label>
                    <button type="submit" name="publish" value="save_as_draft" onclick="this.form.submitted=this.value;" class="btn btn-transparent-info ml-md-5">Save As Draft</button>
                    <button type="submit" name="publish" value="preview" onclick="this.form.submitted=this.value;" class="btn btn-outline-primary ml-md-5">Preview</button>
                </div>
                <div class="my-3 my-lg-0 ml-lg-3">
                    <div class="input-group date">
                        <input type="text" class="form-control bg-white" readonly="readonly" name="published_at" value="@if($stub == 'update'){{$obj ? $obj->published_at : null }}@endif" placeholder="Schedule" id="kt_datetimepicker_2"/>
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
                    <button type="submit" class="btn btn-primary ml-lg-3" onclick="this.form.submitted=this.value;" name="publish" value="now">{{ $stub == 'update' ? 'Update' : 'Publish Now'}}</button>
                
                <!-- Name and value of the button pressed -->
                <input type="hidden" name="publish" id="publishName">
            </div>
        </div>
    </div>
    <!-----end second header--------->

    <!-- SEO -->
    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample6">
        <div class="card border rounded-lg mt-5">
            <div class="card-header" id="headingOne6">
                <div class="card-title collapsed bg-white" data-toggle="collapse" data-target="#seo">
                    <i class="fas fa-tasks"></i> Search Engine Optimization (SEO)
                </div>
            </div>
            <div id="seo" class="collapse" data-parent="#accordionExample6">
                <div class="card-body">
                    <div class="mb-3 bg-secondary text-dark p-3 rounded d-lg-flex align-items-center justify-content-between">
                        <h5 class="m-0">*Please click on refresh for the changes to reflect in the SEO</h5>
                        <button type="submit" name="publish" value="seoRefresh" onclick="this.form.submitted=this.value;" class="btn btn-info mt-3 mt-lg-0"><i class="fas fa-sync-alt"></i> Refresh</button>
                    </div>

                    <!-- Most searched keywords -->
                    @if(!empty($searchConsoleData))
                        @php
                            $count = 0;
                        @endphp
                        <div class="bg-light rounded rounded-3 p-5">
                            <h2 class="text-primary">Most Searched Keywords</h2>
                            @foreach($searchConsoleData as $key=>$value)
                                @if($key == '3Months')
                                    @foreach($value as $k => $v)
                                        @if($k == 'queryData')
                                            @foreach($v as $data)
                                                @if ($count < 10)
                                                    <span class="badge bg-white text-dark m-1 shadow text-wrap text-left">{{ $data['keys'][0] }}</span>
                                                    @php
                                                        $count += 1;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <!-- End Most searched keywords -->

                    <div class="table-reponsive mt-3">
                        <table class="table table-striped table-bordered table-hover rounded">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-center">Expected</th>
                                    <th scope="col" class="text-center">Found</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Title Length</th>
                                    <td class="text-center">50-70 Characters</td>
                                    <td class="text-center">
                                        @if(!empty($title_characters))
                                            {{ $title_characters }} Characters
                                            @if($title_characters > 50 && $title_characters < 70)
                                                <i class="fas fa-check-circle text-success"></i>
                                            @else 
                                                <i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Blog Word Count</th>
                                    <td class="text-center">Min 1,000 Words</td>
                                    <td class="text-center">
                                        @if(!empty($content_words))
                                            {{ $content_words }} Words
                                            @if($content_words > 1000)
                                                <i class="fas fa-check-circle text-success"></i>
                                            @else 
                                                <i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Meta Description Length</th>
                                    <td class="text-center">120-160 Characters</td>
                                    <td class="text-center">
                                        @if(!empty($meta_description))
                                            {{ $meta_description }} Characters
                                            @if($meta_description > 120 && $meta_description < 160)
                                                <i class="fas fa-check-circle text-success"></i>
                                            @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                        @endif 
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Internal Linking</th>
                                    <td class="text-center" id="internalLinks"></td>
                                    <td class="text-center" id="internalLinksCount"></td>
                                </tr>
                                <tr>
                                    <th scope="row">External Linking</th>
                                    <td class="text-center" id="externalLinks"></td>
                                    <td class="text-center" id="externalLinksCount"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Keywords/Tags Found in Title</th>
                                    <th class="text-center">
                                        @if(!empty($title_keywords))
                                            @foreach($title_keywords as $k => $v)
                                                <p class="m-0">
                                                    {{ ucwords($k) }}
                                                </p>
                                            @endforeach
                                        @endif
                                    </th>
                                    <td class="text-center">
                                        @if(!empty($title_keywords))
                                            @foreach($title_keywords as $k => $v)
                                                <p class="m-0">
                                                    {{ $v }}
                                                </p>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Keywords/Tags Found in Content</th>
                                    <th class="text-center">
                                        @if(!empty($content_keywords))
                                            @foreach($content_keywords as $k => $v)
                                                <p class="m-0">
                                                    {{ ucwords($k) }}
                                                </p>
                                            @endforeach
                                        @endif
                                    </th>
                                    <td class="text-center">
                                        @if(!empty($content_keywords))
                                            @foreach($content_keywords as $k => $v)
                                                <p class="m-0">
                                                    {{ $v }}
                                                </p>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Keywords/Tags Found in Meta Title</th>
                                    <th class="text-center">
                                        @if(!empty($meta_title_keywords))
                                            @foreach($meta_title_keywords as $k => $v)
                                                <p class="m-0">
                                                    {{ ucwords($k) }}
                                                </p>
                                            @endforeach
                                        @endif
                                    </th>
                                    <td class="text-center">
                                        @if(!empty($meta_title_keywords))
                                            @foreach($meta_title_keywords as $k => $v)
                                                <p class="m-0">
                                                    {{ $v }}
                                                </p>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Keywords/Tags Found in Meta Description</th>
                                    <th class="text-center">
                                        @if(!empty($meta_description_keywords))
                                            @foreach($meta_description_keywords as $k => $v)
                                                <p class="m-0">
                                                    {{ ucwords($k) }}
                                                </p>
                                            @endforeach
                                        @endif
                                    </th>
                                    <td class="text-center">
                                        @if(!empty($meta_description_keywords))
                                            @foreach($meta_description_keywords as $k => $v)
                                                <p class="m-0">
                                                    {{ $v }}
                                                </p>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End SEO -->

    <!------------begin::Content------------->
    <div class="mt-5">
        <div class="row container m-0 p-0 my-5">
            <div class="col-12 col-lg-9 bg-white p-5 rounded-lg">
                <textarea type="text" id="title" onkeyup="createSlugAndMetaTitle()" required
                    class="form-control p-0 display-3 text-wrap" style="border: none; background: transparent;height:auto;"
                    placeholder="Type your title here"
                    name="title">@if($stub == 'update'){{$obj ? $obj->title : 'Title'}}@else{{ Request::old('title') ? Request::old('title') : null }}@endif</textarea>
                <div class="d-flex align-items-center justify-content-left">
                    <label class="m-0 text-muted">Slug:</label>
                    <input type="text" id="slug" required style="border: none; background: transparent;"
                        class="form-control p-0 d-inline ml-3" placeholder="start-typing-the-title"
                        name="slug" value="@if($stub == 'update'){{$obj ? $obj->slug : null }}@else{{ Request::old('slug') ? Request::old('slug') : null }}@endif"/>
                </div>
                <textarea type="text" required
                    class="form-control border h-auto px-3 py-3 mb-3 font-size-h6"
                    name="excerpt" placeholder="Give a Description" style="min-height: 140px;"/>@if($stub == 'update'){{$obj ? $obj->excerpt : null }}@else{{ Request::old('excerpt') ? Request::old('excerpt') : null }}@endif</textarea>

                <!-- Content -->
                <textarea name="content" hidden id="post_content"></textarea>

                @if(!empty($obj->content))
                    <textarea id="post_editor">{!! $obj->content !!}</textarea>
                @else
                    @if(!empty($template))
                        <textarea id="post_editor">{!! $template !!}</textarea>
                    @else
                        <textarea id="post_editor">{{ Request::old('content') ? Request::old('content') : null }}</textarea>
                    @endif
                @endif

            </div>

            <!-- Right Column -->
            <div class="col-12 col-lg-3 mt-5 mt-lg-0 px-0 pl-lg-5">
                <div class="bg-white p-5 rounded-lg">
                    <!-- Featured -->
                    <div class="p-3 bg-white my-3 rounded-lg shadow-sm">
                        <label class="checkbox">
                            <input type="checkbox" name="featured" @if($stub == 'update'){{$obj->featured == 'on' ? 'checked' : null }}@endif/>
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
                                            <input class="form-check-input" type="radio" name="visibility" id="public" value="public" onclick="showGroup()" @if($stub == 'update'){{$obj->visibility == 'public' ? 'checked' : null }}@else {{ 'checked' }}@endif>
                                            <label class="form-check-label" for="inlineRadio1">Public</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="visibility" id="private" value="private" onclick="showGroup()" @if($stub == 'update'){{$obj->visibility == 'private' ? 'checked' : null }}@endif>
                                            <label class="form-check-label" for="inlineRadio2">Private</label>
                                        </div>
                                     </div>
                                    <!--end::Form Group-->
                                    <textarea name="group" id="group" class="form-control bg-light mt-3" cols="30" rows="3" style="resize: none; display:@if($stub == 'update'){{$obj->visibility == 'private' ? 'block' : 'none'}}@else {{ 'none' }}@endif;" placeholder="Type in Comma Separated Group Names">@if($stub == 'update'){{$obj->group ? $obj->group : null }}@endif</textarea>
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
                        
                        <input type="hidden" id="image_url" name="image" value="@if($stub == 'update'){{$obj ? $obj->image : null }}@endif">
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
                                        <textarea type="text" id="meta_title" rows="3"
                                            class="form-control h-auto bg-light border mb-2 p-3 rounded-md font-size-h6"
                                            name="meta_title" placeholder="Title">@if($stub == 'update'){{$obj ? $obj->meta_title : null }}@else{{ Request::old('meta_title') ? Request::old('meta_title') : null }}@endif</textarea>
                                        <textarea type="text" rows="8"
                                            class="form-control h-auto border bg-light p-3 rounded-md font-size-h6"
                                            name="meta_description" placeholder="Description">@if($stub == 'update'){{$obj ? $obj->meta_description : null }}@else{{ Request::old('meta_description') ? Request::old('meta_description') : null }}@endif</textarea>
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
                                    <select class="form-control select2" style="min-height: 2.5rem;" id="kt_select2_11" name="tag_ids[]" multiple="multiple" placeholder="Add a Tag" onkeyup="myFunction()">

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