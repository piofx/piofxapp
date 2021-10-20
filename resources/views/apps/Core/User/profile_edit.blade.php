
<x-dynamic-component :component="$app->componentName" class="mt-4" >

<!--begin::Breadcrumb-->
<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
        <a href="{{ route('profile')}}" class="text-muted">Profile</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted">{{ $obj->name }}</a>
    </li>
</ul>
<!--end::Breadcrumb-->

<form method="POST" action="{{route('profile.update',$obj->id)}}" enctype="multipart/form-data">
 
<!--begin::basic card-->
<x-snippets.cards.action :title="$app->module " class="border"  >

<div class="row">
  <div class="col-12 col-md-4">
    <div class="js-form-message form-group mb-4">
        <label for="inputName" class="input-label">Name</label>
        <input type="text" class="form-control" name="name" id="inputName" placeholder="Alex Hecker" aria-label="Alex Hecker" required
               data-msg="Please enter your name." value="@if(isset($obj->name)) {{$obj->name}} @endif">
      </div>

  </div>
  <div class="col-12 col-md-4">
    <div class="js-form-message form-group mb-4">
        <label for="emailAddressExample2" class="input-label">Phone</label>
        <input type="text" class="form-control" name="phone" id="emailAddressExample2" required
               data-msg="Please enter a valid phone number" value="@if(isset($obj->phone)) {{$obj->phone}} @endif">
      </div>

  </div>
  <div class="col-12 col-md-4">
    <div class="js-form-message form-group mb-4">
        <label for="emailAddressExample2" class="input-label">Email address</label>
        <input type="email" class="form-control" name="email" id="emailAddressExample2" placeholder="alexhecker@pixeel.com" aria-label="alexhecker@pixeel.com" required
               data-msg="Please enter a valid email address." value="@if(isset($obj->email)) {{$obj->email}} @endif">
      </div>

  </div>
</div>
    

    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id" value="{{ $obj->id }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
    <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
  
</x-snippets.cards.action>
<!--end::basic card-->   
</form>

</x-dynamic-component>