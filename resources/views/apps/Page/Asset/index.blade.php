<x-dynamic-component :component="$app->componentName" class="mt-4" >

 <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
      <li class="breadcrumb-item">
        <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('Theme.index') }}"  class="text-muted">Themes</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('Theme.show',$app->id) }}"  class="text-muted">Current Theme</a>
      </li>
      <li class="breadcrumb-item">
        <a href="" class="text-muted">{{ $app->module}}</a>
      </li>
    </ul>
    <!--end::Breadcrumb-->

  <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->

<div class='row'>
  <div class="col-12 col-md-2">
    @include('apps.Page.snippets.menu')
  </div>
  <div class="col-12 col-md-10">
  <!--begin::Indexcard-->
  <x-snippets.cards.indexcard title="Assets"  :module="$app->module" :action="route($app->module.'.index',$app->id)" :appid="$app->id"  />
  <!--end::Indexcard-->


  <div class="row">

   
    <div class="col-12 col-md-10">
      <!--begin::basic card-->
      <x-snippets.cards.basic>
        @if($objs->total()!=0)
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                  <tr>
                    <th scope="col">#({{$objs->total()}})</th>
                    <th scope="col">Name </th>
                    <th scope="col">Type</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($objs as $key=>$obj)  
                  <tr>
                    <th scope="row">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                    <td>
                      <a href=" {{ route($app->module.'.show',[$app->id,$obj->id]) }} ">
                      {{ $obj->name }}
                      </a>
                    </td>
                    <td>{{ $obj->type }}</td>
                    <td>{{ $obj->slug }}</td>
                    <td>@if($obj->status==0)
                        <span class="badge badge-warning">Inactive</span>
                        @elseif($obj->status==1)
                        <span class="badge badge-success">Active</span>
                      @endif</td>
                    <td>{{ ($obj->created_at) ? $obj->created_at->diffForHumans() : '' }}</td>
                  </tr>
                  @endforeach      
                </tbody>
              </table>
            </div>
            @else
            <div class="card card-body bg-light">
              No items found
            </div>
            @endif
            
          <nav aria-label="Page navigation  " class="card-nav @if($objs->total() > config('global.no_of_records'))mt-3 @endif">
        {{$objs->links()  }}
      </nav>
      </x-snippets.cards.basic>
      <!--end::basic card-->

    </div>
     <div class="col-12 col-md-2">

      <div class="list-group">
        <a href="{{ route('Asset.index',$app->id)}}" class="list-group-item list-group-item-action @if(!request()->get('filter')) active @endif" aria-current="true">
          All
        </a>
        <a href="{{ route('Asset.index',$app->id)}}?filter=css" class="list-group-item list-group-item-action @if(request()->get('filter') =='css') active @endif">CSS</a>
        <a href="{{ route('Asset.index',$app->id)}}?filter=js" class="list-group-item list-group-item-action @if(request()->get('filter') =='js') active @endif">JS</a>
        <a href="{{ route('Asset.index',$app->id)}}?filter=images" class="list-group-item list-group-item-action @if(request()->get('filter') =='images') active @endif">Images</a>
        <a href="{{ route('Asset.index',$app->id)}}?filter=fonts" class="list-group-item list-group-item-action @if(request()->get('filter') =='fonts') active @endif">fonts</a>
      </div>
      <a href="" class="btn btn-warning  w-100 my-3" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-cloud"></i> Upload</a>
    </div>
  </div>
  
</div>

</div>  

<!-- Modal-->
<div class="modal fade" id="exampleModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="post" action="{{route($app->module.'.store',$app->id)}}" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bulk Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                 <div class="form-group">
                  <label for="exampleFormControlFile1">Select multiplee files</label>
                  <input type="file" class="form-control-file" name="files[]" id="exampleFormControlFile1" multiple>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                  <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
                  <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
                  <input type="hidden" name="theme_id" value="{{ $app->id }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success  font-weight-bold">upload</button>
            </div>
            </form>
        </div>
    </div>
</div>

</x-dynamic-component>