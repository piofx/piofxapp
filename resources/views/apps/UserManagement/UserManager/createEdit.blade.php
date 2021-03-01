<x-dynamic-component :component="$app->componentName">

  <div class="container my-5 bg-white rounded-lg p-5 shadow-sm">
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Sorry!</strong> There were some problems with your HTML input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div> 
    @endif

    @if($stub == "create")
        <form method="POST" action="{{ route($app->module.'.store') }}" enctype="multipart/form-data">
    @else
        <form method="POST" action="{{ route($app->module.'.update', $obj->id) }}" enctype="multipart/form-data">
    @endif
     
      <h3 class="text-center font-weight-bold my-5">Create User Account</h3>
        <div class="form-row">
            <div class="form-group col-md-6">
                <h5>First Name :</h5>
                <input type="text" class="form-control" placeholder="Enter First name" name="firstname" value="@if($stub == 'update'){{ $obj ? $obj->firstname : '' }}@endif">
            </div>
            <div class="form-group col-md-6">
                <h5>Last Name :</h5>
                <input type="text" class="form-control" placeholder="Enter Last name" name="lastname" value="@if($stub == 'update'){{ $obj ? $obj->lastname : '' }}@endif">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-12 @if($stub != 'update'){{'col-md-6'}}@endif">
                <h5>Email :</h5>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="@if($stub == 'update'){{ $obj ? $obj->email : '' }}@endif">
            </div>
            @if($stub != 'update')
                <div class="form-group col-md-6">
                    <h5>Password :</h5>
                    <input type="password" class="form-control" id="inputPassword4" placeholder="Password" name="password" value="@if($stub == 'update'){{ $obj ? $obj->password : '' }}@endif">
                </div>
            @endif
        </div>
        <div class="form-group">
            <label class="mt-3">Phone:</label>
            <div class="input-group">
                <div class="input-group-text">+91</div>
                <input type="text" class="form-control" name="phone" value="{{ old('phone') }} @if($stub == 'update'){{ $obj->phone }}@endif">
            </div>
        </div>
        <div class="form-group">
            <h5>Date Of Birth :</h5>
            <input class="form-control" type="date" id="birthday" name="date_of_birth" value="@if($stub == 'update'){{ $obj ? $obj->date_of_birth : '' }}@endif">
        </div>
        <div class="form-group">
            <h5>Address:</h5>
            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address" value="@if($stub == 'update'){{ $obj ? $obj->address : '' }}@endif">
        </div>
        <div class="form-group">
            <h5>Address 2 :</h5>
            <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" name="address2" value="@if($stub == 'update'){{ $obj ? $obj->address : '' }}@endif">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <h5>City :</h5>
                <input type="text" class="form-control" id="inputCity" name="city" value="@if($stub == 'update'){{ $obj ? $obj->city : '' }}@endif">
            </div>
            <div class="form-group col-md-4">
                <h5>State :</h5>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Telangana" name="state" value="@if($stub == 'update'){{ $obj ? $obj->state : '' }}@endif">
            </div>
            <div class="form-group col-md-2">
                <h5>Zip :</h5>
                <input type="text" class="form-control" id="inputZip" name="zip" value="@if($stub == 'update'){{ $obj ? $obj->zip : '' }}@endif">
            </div>
        </div>
        @if($stub=='update')
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="{{ $obj->id }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">  
        @endif
   
        <button type="submit" class="btn btn-primary mt-3">Create</button>
    </form>
  </div>
</x-dynamic-component>