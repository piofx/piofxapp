
<x-dynamic-component :component="$app->componentName" class="mt-4" >





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
  <div class="card">
    <div class="card-body">
      <div class="js-form-message form-group mb-4">
        <label for="inputName" class="input-label">Name</label>
        <input type="text" class="form-control" name="name" id="inputName" placeholder="Enter your name" required
        data-msg="Please enter your name." value="@if(isset($obj->name)) {{$obj->name}} @endif">
      </div>
      <div class="js-form-message form-group mb-4">
        <label for="emailAddressExample2" class="input-label">Email address</label>
        <input type="email" class="form-control" name="email" id="emailAddressExample2" placeholder="Your email id" aria-label="alexhecker@pixeel.com" required
        data-msg="Please enter a valid email address." value="@if(isset($obj->email)) {{$obj->email}} @endif">
      </div>
      <div class="js-form-message form-group mb-4">
        <label for="descriptionTextarea" class="input-label">Message</label>
        <textarea class="form-control" rows="3" name="message" id="descriptionTextarea" placeholder="Hi there, I would like to ..." required
        data-msg="Please enter your message.">@if(isset($obj->message)) {{$obj->message}} @endif</textarea>
      </div>
    </div>
    @if($stub=='Update')
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id" value="{{ $obj->id }}">
    @endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
    <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">

    <div class="card-footer bg-gray-100 border-top-0  p-3">
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

</x-dynamic-component>