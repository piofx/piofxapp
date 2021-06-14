<x-dynamic-component :component="$app->componentName">
    @if($stub == 'create')
        <form action="{{ route($app->module.'.store') }}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{{ route($app->module.'.update',$obj->id) }}" method="POST" enctype="multipart/form-data">
    @endif
        <x-snippets.cards.action :title="$app->module " class="border">
              <div class="form-row">
                  <div class="form-group col-md-6">
                    <h6 for="name">Name</h6>
                    <input type="name" id="title" class="form-control"  placeholder="name" name="name" value="@if($stub == 'update'){{$obj ? $obj->name : ''}}@endif" onkeyup="createSlug()">
                  </div>
                  <div class="form-group col-md-6">
                      <h6 for="description">Description</h6>
                      <input type="description" class="form-control" id="description" placeholder="description" name="description" value="@if($stub == 'update'){{$obj ? $obj->description : ''}}@endif">
                  </div>
              </div>
              <div class="form-row">
                    <h6 for="inputAddress">Template</h6>
                      <select class="form-control"  name="mail_template_id">
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}" @if($stub == 'update') @if($obj->mail_template_id == $template->id){{ 'selected' }}@else '' @endif @endif>{{ $template->name }}</option>
                            @endforeach
                      </select>                      
               </div>
                  <div class="form-group">
                    <h6 for="inputState">Emails</h6>
                    <textarea type="text" class="form-control" rows="5"  name="emails">@if($stub == 'update'){{$obj->emails ? $obj->emails : ''}}
                    @endif</textarea>
                  </div>
                  <div class="form-group">
                    <h6 for="inputState">Scheduled_At</h6>
                    <input type="text" class="form-control" id="datetimepicker1" name="scheduled_at" value="@if($stub == 'update'){{$obj->scheduled_at}}@endif">
                    <span class="glyphicon glyphicon-calendar"></span>
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
              <input type="text" hidden name="timezone" id="timezone">
              @if($stub=='update')
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="id" value="{{ $obj->id }}">
              @endif
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  
     </x-snippets.cards.action>
   </form>
</x-dynamic-component>
