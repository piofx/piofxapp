<x-dynamic-component :component="$app->componentName">
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    @if($stub == 'create')
        <form action="{{ route($app->module.'.store') }}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{{ route($app->module.'.update',$obj->slug) }}" method="POST" enctype="multipart/form-data">
    @endif
        <x-snippets.cards.action :title="$app->module " class="border">
              <div class="form-row">
                  <div class="form-group col-md-6">
                    <h6 for="inputEmail4">Name</h6>
                    <input type="name" id="title" class="form-control"  placeholder="name" name="name" value="@if($stub == 'Update'){{$obj ? $obj->name : ''}}@endif" onkeyup="createSlug()">
                  </div>
                  <div class="form-group col-md-6">
                      <h6 for="slug">Slug</h6>
                      <input type="slug" class="form-control" id="slug" placeholder="slug" name="slug" value="@if($stub == 'Update'){{$obj ? $obj->slug : ''}}@endif">
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-6">
                    <h6 for="inputAddress">Category</h6>
                      <select class="form-control"  name="template_category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($stub == 'Update') @if($obj->template_category_id == $category->id){{ 'selected' }}@else '' @endif @endif>{{ $category->name }}</option>
                            @endforeach
                      </select>                              
                  </div>
                <div class="form-group col-md-6">
                    <h6 for="inputCity">Preview Path</h6>
                    <input type="text" class="form-control" name="preview_path" value="@if($stub == 'Update'){{$obj ? $obj->preview_path : ''}}@endif">
                  </div>
              </div>
                  <div class="form-group">
                    <h6 for="inputState">Download Path</h6>
                    <input type="text" class="form-control" name="download_path" value="@if($stub == 'Update'){{$obj ? $obj->download_path : ''}}@endif">
                  </div>
              <div class="form-row">
                  <div class="form-group col-md-6">
                      <h6 for="inputCity">Index Screenshot</h6>
                      <input type="text" class="form-control"  name="index_screenshot" value="@if($stub == 'Update'){{$obj ? $obj->index_screenshot : ''}}@endif">
                  </div>
                  <div class="form-group">
                    <label for="formGroupExampleInput ">Status </label>
                    <div class="col-9 col-form-label">
                    <div class="radio-inline">
                        <label class="radio radio-success">
                            <input type="radio" name="status" @if(isset($obj)) @if($obj->status==1) checked="checked" @endif @endif value="1"/>
                            <span></span>
                            Active
                        </label>
                        <label class="radio radio-danger">
                            <input type="radio" name="status" @if(isset($obj)) @if($obj->status==0) checked="checked" @endif @endif value="0"/>
                            <span></span>
                            Inactive
                        </label>
                    </div>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                <h6 for="inputAddress2">Tags</h6>
                    <!------begin Tags------>
                    <select class="form-control select2" style="min-height: 2.5rem;" id="kt_select2_11" name="tag_ids[]" multiple="multiple" placeholder="Add a Tag">
                    @php
                        $tag_ids = [];
                        foreach($obj->template_tags as $tag){
                            array_push($tag_ids, $tag->id);
                        }
                    @endphp

                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" @if($stub == "Update") @if(in_array($tag->id, $tag_ids)) {{ "selected" }} @endif @endif> {{ $tag->name }} </option>
                    @endforeach

                    </select>
            </div>
              <div class="form-row">
                  <h6 for="inputState">Screens<br>
                  <small id="emailHelp" class="form-text text-muted">Only Enter json data.</small>
                  </h6>
                  <textarea placeholder="{
                    'About' : 'https://image.com/image.png',
                    'services' : 'https://image.com/image.png'
}" type="text" class="form-control" rows="10"  name="screens">@if($stub == 'Update'){{$obj->screens ? $obj->screens : ''}}
                    @endif</textarea>
              </div>
              @if($stub=='Update')
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="id" value="{{ $obj->id }}">
              @endif
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
     </x-snippets.cards.action>
   </form>
</x-dynamic-component>
