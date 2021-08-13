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
                    <h6 for="name">Name</h6>
                    <input type="name" id="title" class="form-control"  placeholder="name" name="name" value="@if($stub == 'update'){{$obj ? $obj->name : ''}}@endif" onkeyup="createSlug()">
                  </div>
                  <div class="form-group col-md-6">
                      <h6 for="slug">Slug</h6>
                      <input type="slug" class="form-control" id="slug" placeholder="slug" name="slug" value="@if($stub == 'update'){{$obj ? $obj->slug : ''}}@endif">
                  </div>
              </div>
                  <div class="form-group">
                    <h6 for="inputState">Subject</h6>
                    <input type="text" class="form-control" name="subject" value="@if($stub == 'update'){{$obj ? $obj->subject : ''}}@endif">
                  </div>
              <div class="form-row">
                  <div class="form-group">
                    <h6>Status </h6>
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
              <div class="mt-5">
                <h6>Message </h6>
                    <div id="content" style="min-height: 800px"></div>
                    <textarea id="content_editor" class="form-control border d-none" name="message" rows="5">@if($stub == 'update'){{$obj ? $obj->message : ''}}@endif</textarea>
                </div>
              @if($stub=='update')
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="id" value="{{ $obj->id }}">
              @endif
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
     </x-snippets.cards.action>
   </form>
</x-dynamic-component>
