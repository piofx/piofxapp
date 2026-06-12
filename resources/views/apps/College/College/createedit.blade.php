
<x-dynamic-component :component="$app->componentName" class="mt-4" >

  <!--begin::Breadcrumb-->
  <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
      <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
      <a href="{{ route($app->module.'.index') }}"  class="text-muted">{{ ucfirst($app->module) }}</a>
    </li>
    @if($stub!='Create')
    <li class="breadcrumb-item">
      <a href="" class="text-muted">{{ $obj->name }}</a>
    </li>
    @endif
  </ul>
  <!--end::Breadcrumb-->



  <!--begin::basic card-->
  <x-snippets.cards.basic>
      <h1 class="p-5 rounded border bg-light mb-3">
        @if($stub=='Create')
          Create {{ $app->module }}
        @else
          Update {{ $app->module }}
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route($app->module.'.store')}}" enctype="multipart/form-data">
      @else
      <form method="post" action="{{route($app->module.'.update',$obj->id)}}" enctype="multipart/form-data">
      @endif  

      <div class="row">
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">{{ ucfirst($app->module)}} Name</label>
            <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Category Name" 
                @if($stub=='Create')
                value="{{ (old('name')) ? old('name') : '' }}"
                @else
                value = "{{ $obj->name }}"
                @endif
              >
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">College Code</label>
            <input type="text" class="form-control" name="code" placeholder="Enter College Code" 
                @if($stub=='Create')
                value="{{ (old('code')) ? old('code') : '' }}"
                @else
                value = "{{ $obj->code }}"
                @endif
              >
          </div>
        </div>
        <div class="col-12 col-md-4">
           <div class="form-group">
            <label for="formGroupExampleInput ">College Type </label>
            <select class="form-control" name="type">
              <option value="engineering" @if(isset($obj)) @if($obj->type=='engineering') selected @endif @endif >Engineering</option>
              <option value="degree" @if(isset($obj)) @if($obj->type=='degree') selected @endif @endif >Degree</option>
              <option value="other" @if(isset($obj)) @if($obj->type=='other') selected @endif @endif >Other</option>
            </select>
          </div>
        </div>
      </div>
       <div class="row">
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Location</label>
            <input type="text" class="form-control" name="location" 
                @if($stub=='Create')
                value="{{ (old('location')) ? old('location') : '' }}"
                @else
                value = "{{ $obj->location }}"
                @endif
              >
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Zone</label>
            <input class="form-control" list="datalistZones" name="zone" id="exampleDataList" placeholder="Type to search..."
              @if(isset($obj->zone)) 
              value = "{{ $obj->zone}}"
              @endif
            >
            <datalist id="datalistZones">
               @foreach($data['zones'] as $d)
                <option value="{{$d}}">
              @endforeach
            </datalist>
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">District</label>
            <input class="form-control" list="datalistDistricts" name="district" id="exampleDataList" placeholder="Type to search..."
              @if(isset($obj->district)) 
              value = "{{ $obj->district }}"
              @endif
            >
            <datalist id="datalistDistricts">
               @foreach($data['districts'] as $d)
                <option value="{{$d}}">
              @endforeach
            </datalist>
          </div>

        </div>
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">State</label>
            <input class="form-control" list="datalistState" id="exampleDataList" name="state" placeholder="Type to search..."
              @if(isset($obj->state)) 
              value = "{{ $obj->state }}"
              @endif
            >
            <datalist id="datalistState">
               @foreach($data['states'] as $d)
                <option value="{{$d}}">
              @endforeach
            </datalist>
          </div>

        </div>
      </div>
       <div class="row">
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Contact Person</label>
            <input type="text" class="form-control" name="contact_person" 
                @if($stub=='Create')
                value="{{ (old('contact_person')) ? old('contact_person') : '' }}"
                @else
                value = "{{ $obj->contact_person }}"
                @endif
              >
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Contact Designation</label>
            <input class="form-control" list="datalistDesignations" name="contact_designation" id="exampleDataList" placeholder="Type to search..."
              @if(isset($obj->contact_designation)) 
              value = "{{ $obj->contact_designation }}"
              @endif
            >
            <datalist id="datalistDesignations">
               @foreach($data['designations'] as $d)
                <option value="{{$d}}">
              @endforeach
            </datalist>
          </div>

        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Contact Phone</label>
            <input type="text" class="form-control" name="contact_phone" 
                @if($stub=='Create')
                value="{{ (old('contact_phone')) ? old('contact_phone') : '' }}"
                @else
                value = "{{ $obj->contact_phone }}"
                @endif
              >
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Contact Email</label>
            <input type="text" class="form-control" name="contact_email" 
                @if($stub=='Create')
                value="{{ (old('contact_email')) ? old('contact_email') : '' }}"
                @else
                value = "{{ $obj->contact_email }}"
                @endif
              >
          </div>
          
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Data Volume</label>
            <input type="text" class="form-control" name="data_volume" 
                @if($stub=='Create')
                value="{{ (old('data_volume')) ? old('data_volume') : '' }}"
                @else
                value = "{{ $obj->data_volume }}"
                @endif
              >
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Status </label>
            <select class="form-control" name="status">
              <option value="0" @if(isset($obj)) @if($obj->status==0) selected @endif @endif >Inactive</option>
              <option value="1" @if(isset($obj)) @if($obj->status==1) selected @endif @endif >Active</option>
            </select>
          </div>
        </div>
      </div>      

      @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $obj->id }}">
      @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
      <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
        <button type="submit" class="btn btn-info btn-lg">Save</button>
    </form>
    
  </x-snippets.cards.basic>
  <!--end::basic card-->   

</x-dynamic-component>