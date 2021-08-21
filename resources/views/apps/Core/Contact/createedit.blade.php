<x-dynamic-component :component="$app->componentName" class="mt-4" >

  @if(isset($prefix))
      @if($prefix)
        {!! $prefix !!} 
      @endif
  @else
      @if(isset($settings))@if(isset($settings->prefix)) {!! $settings->prefix !!} @endif @endif
  @endif

  @if($stub=='Create')
    <form method="post" action="{{route($app->module.'.store')}}" enctype="multipart/form-data">
  @else
    <form method="post" action="{{route($app->module.'.update',$obj->id)}}" enctype="multipart/form-data">
  @endif  

  <!--begin::Alert-->
  @if($alert)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      {{$alert}}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  <!--end::Alert-->

	<!--begin::basic card-->
  <div class="container ">
    <div class="card border">
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-4">
            <div class="js-form-message form-group mb-4">
              <label for="inputName" class="input-label">Name</label>
              <input type="text" class="form-control" name="name" id="inputName" placeholder="Enter your name" required
              data-msg="Please enter your name." value="@if(isset($obj->name)) {{$obj->name}} @endif">
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="js-form-message form-group mb-4">
              <label for="emailAddressExample2" class="input-label">Phone</label>
              <input type="text" class="form-control" name="phone" id="phoneExample3"  placeholder="Your phone" required
              data-msg="Please enter a valid phone number." value="@if(isset($obj->phone)) {{$obj->phone}} @endif">
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="js-form-message form-group mb-4">
                <label for="emailAddressExample2" class="input-label">Email address</label>
                <input type="email" class="form-control" name="email" id="emailAddressExample2" placeholder="Your email id" aria-label="alexhecker@pixeel.com" required
                data-msg="Please enter a valid email address." value="@if(isset($obj->email)) {{$obj->email}} @endif">
              </div>

          </div>
        </div>
        
        @if($stub=='Create')
          @if(!$form)
            <div class="js-form-message form-group mb-4">
              <label for="descriptionTextarea" class="input-label">Message</label>
              <textarea class="form-control" rows="3" name="message" id="descriptionTextarea" placeholder="Hi there, I would like to ..." required
              data-msg="Please enter your message.">@if(isset($obj->message)) {{$obj->message}} @endif</textarea>
            </div>
          @else
            @foreach($form as $k=>$f)
              @if($f['type']=='input')
              <div class="js-form-message form-group mb-4">
                <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
                <input type="text" class="form-control" name="settings_{{ str_replace(' ','_',$f['name'])}}" required >
              </div>
              @elseif($f['type']=='textarea')
              <div class="js-form-message form-group mb-4">
                <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="settings_{{ str_replace(' ','_',$f['name'])}}" rows="{{$f['values']}}"></textarea>
              </div>
              @elseif($f['type']=='radio')
              <div class="js-form-message form-group mb-4">
                <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
                <select class="form-control" name="settings_{{ str_replace(' ','_',$f['name'])}}"  id="exampleFormControlSelect1">
                  @foreach($f['values'] as $v)
                  <option value="{{$v}}">{{$v}}</option>
                  @endforeach
                </select>
              </div>
              @elseif($f['type']=='file')
              <div class="js-form-message form-group mb-4">
                <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
                <input type="file" class="form-control-file" name="settings_{{ str_replace(' ','_',$f['name'])}}" id="exampleFormControlFile1">
              </div>
              @else
              <div class="js-form-message form-group mb-4">
                <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
                  @foreach($f['values'] as $m=>$v)
                <div class="form-check">
                  <input class="form-check-input" name="settings_{{ str_replace(' ','_',$f['name'])}}[]" type="checkbox" value="{{$v}}" id="defaultCheck{{$m}}">
                  <label class="form-check-label" for="defaultCheck{{$m}}">
                    {{$v}}
                  </label>
                </div>
                @endforeach
              </div>
              @endif
            @endforeach
          @endif
        @else
            <div class="js-form-message form-group mb-4">
              <label for="descriptionTextarea" class="input-label">Message</label>
              <textarea class="form-control" rows="3" name="message" id="descriptionTextarea" placeholder="Hi there, I would like to ..." required data-msg="Please enter your message.">@if(isset($obj->message)) {{$obj->message}} @endif</textarea>
            </div>
        @endif

        @if($stub=='Update')
        <div class="js-form-message form-group mb-4">
              <label for="descriptionTextarea" class="input-label">Comment</label>
              <textarea class="form-control" rows="3" name="comment" id="descriptionTextarea" placeholder="" required
              data-msg="Please enter your message.">@if(isset($obj->comment)) {{$obj->comment}} @endif</textarea>
            </div>

        <div class="row">
          <div class="col-12 col-md-6">
            <div class="js-form-message form-group mb-4">
              <label for="formGroupExampleInput ">Status</label>
              <select class="form-control" name="status">
                <option value="1" @if(isset($obj)) @if($obj->status==1) selected @endif @endif >Open Lead</option>
                <option value="5" @if(isset($obj)) @if($obj->status==5) selected @endif @endif >Not Responded</option>
                <option value="2" @if(isset($obj)) @if($obj->status==2) selected @endif @endif >Cold Lead</option>
                <option value="3" @if(isset($obj)) @if($obj->status==3) selected @endif @endif >Warm Lead</option>
                <option value="4" @if(isset($obj)) @if($obj->status==4) selected @endif @endif >Prospect</option>
                <option value="0" @if(isset($obj)) @if($obj->status==0) selected @endif @endif >Customer</option>
                
              </select>
          </div>

          </div>
          <div class="col-12 col-md-6">
            <label for="des" class="input-label">Tags</label>
      
          <select class="form-control select2" id="kt_select2_3" name="tags[]" multiple="multiple">
            @if($obj->getSettingsTags())

            @foreach(explode(',',$obj->getSettingsTags()) as $tag)
            <option value="{{$tag}}" @if(in_array($tag,$obj->tags())) selected @endif>{{$tag}}</option>
            @endforeach
            @endif
          </select>
          </div>
        </div>
          
        @endif



      </div>
      @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $obj->id }}">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          <input type="hidden" name="category" value="{{$obj->category}}">
    @else
    <input type="hidden" name="category" value="@if(request()->get('category')) {{request()->get('category')}} @else contact @endif">
    
      @endif
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
      <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">

      <div class="card-footer bg-gray-100 border-top-0  p-4">
        <div class="row align-items-center">
        <div class="col text-left">
          <button type="submit" class="btn btn-primary font-weight-bold mr-2">Submit</button>
          <a href="{{url()->previous()}}"  class="btn btn-outline-info font-weight-bold">Cancel</a>
          </div>
        </div>
      </div>
    </div>
    <!--end::basic card-->   
    </form>
  </div>

  @if(isset($suffix))
    @if($suffix)
      {!! $suffix!!} 
    @endif
  @else
    @if(isset($settings))@if(isset($settings->suffix)) {!! $settings->suffix !!} @endif @endif
  @endif

</x-dynamic-component>