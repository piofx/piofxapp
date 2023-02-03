<x-dynamic-component :component="$app->componentName" class="mt-4" >

  <!--begin::Breadcrumb-->
  <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
      <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
      <a href=""  class="text-muted">{{ ucfirst($app->module) }}</a>
    </li>
  </ul>
  <!--end::Breadcrumb-->

  <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->


  <!--begin::Indexcard-->

@props(['appid' => 0,'title'=>'Default','action'=>'url','module'=>'mod'])

<!--begin::Indexcard-->
<div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-success">
 <div class="card-body">
  <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
   <div class="d-flex flex-column mr-5">
    <a href="#" class="h2 text-dark text-hover-primary mb-0">
    {{$title}}
    </a> 
   </div>
   <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
    <!--begin::Form-->
    <form class="form" action="{{$action}}" method="get">
      <div class="row">
        <div class="col-12 col-md-6">
         <div class="input-icon">
           <input type="text" class="form-control" name="item" placeholder="Search..." @if(request()->get('item')) value="{{request()->get('item')}}" @endif style="max-width:150px"/>
           <span><i class="flaticon2-search-1 icon-md"></i></span>
         </div>
       </div>
       @if(\Auth::user()->isAdmin() || \Auth::user()->isRole('clientmoderator'))
         <div class="col-12 col-md-6">
          @if($appid)
          <a href="{{ route($module.'.create',$appid) }}" class="btn btn-primary mt-1 mt-md-0"  >
            <i class="flaticon-plus"></i> Create Record
          </a>
          @else
          <a href="{{ route($module.'.create') }}" class="btn btn-primary mt-1 mt-md-0"  >
            <i class="flaticon-plus"></i> Create Record
          </a>
          @endif
        </div>
        @endif
      </div>
    </form>
    <!--end::Form-->
   
   </div>
  </div>
 </div>
</div>

<!--end::Indexcard-->
  <!--end::Indexcard-->

  <div class="row">
    <div class="col-12 col-md-9">

      <div class="row">
        <div class="col-6 col-md-3">
          <x-snippets.cards.basic class="bg-light-warning border border-warning mb-5">
            <h5>All Colleges <a href="#" data-toggle="tooltip" title="Total Colleges"><i class="flaticon-exclamation-2"></i></a></h5>
            <div class="display-3">
             {{ $data['types']['all']}}
            </div>
          </x-snippets.cards.basic>
        </div>
        <div class="col-6 col-md-3">
          <x-snippets.cards.basic class="bg-light-info border border-info mb-5">
            <h5>Engineering <a href="#" data-toggle="tooltip" title="Engineering Colleges"><i class="flaticon-exclamation-2"></i></a></h5>
            <div class="display-3">
              {{ $data['types']['engineering']}}
            </div>
          </x-snippets.cards.basic>
        </div>
        <div class="col-6 col-md-3">
           <x-snippets.cards.basic class="bg-light-danger border border-danger mb-5">
            <h5>Degree <a href="#" data-toggle="tooltip" title="Degree Colleges"><i class="flaticon-exclamation-2"></i></a></h5>
            <div class="display-3">
              {{ $data['types']['degree']}}
            </div>
          </x-snippets.cards.basic>
        </div>
        <div class="col-6 col-md-3">
           <x-snippets.cards.basic class="bg-light-primary border border-primary mb-5">
            <h5>Other <a href="#" data-toggle="tooltip" title="Other "><i class="flaticon-exclamation-2"></i></a></h5>
            <div class="display-3">
              {{ $data['types']['other']}}
            </div>
          </x-snippets.cards.basic>

        </div>
      </div>
      <!--begin::basic card-->
      <x-snippets.cards.basic>
        @if($objs->total()!=0)
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                  <tr>
                    <th scope="col">#({{$objs->total()}})</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Registered</th>
                    <th scope="col">Volume</th>
                    <th scope="col">Location</th>
                    <th scope="col">Zone</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($objs as $key=>$obj)  

                  <tr>
                    <th scope="row">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                    <td>
                      <a href="{{route($app->module.'.show',$obj->id)}}">
                      {{ $obj->name }}
                      </a>
                    </td>
                    <td>
                      @if($obj->type=="engineering")
                        <span class="badge badge-primary">Engineering</span>
                        @elseif($obj->type=="degree")
                        <span class="badge badge-success">Degree</span>
                        @else
                        <span class="badge badge-warning">Other</span>
                      @endif
                    </td>
                    <td>
                     {{$obj->registered}}
                    </td>
                    <td>{{ $obj->data_volume }}</td>
                    <td>{{ $obj->location }}</td>
                    <td>{{ $obj->zone }}</td>
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
            {{$objs->appends(request()->except(['page','search']))->links()  }}
          </nav>
      </x-snippets.cards.basic>
      <!--end::basic card-->

    </div>
    <div class="col-12 col-md-3">

      <div class="py-3">
        <a  href="{{route('College.upload')}}" class="btn btn-info w-100">Upload CVS file</a>
      </div>
      <!--begin::List Widget 7-->
      <div class="card card-custom gutter-b">
          <!--begin::Header-->
            <div class="card-header border-0">
              <h3 class="card-title font-weight-bolder text-dark">Zones</h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0">
               <a href="{{ route('College.index')}}" class="btn font-weight-bold btn-light-info mr-2 mb-2">All Zones </a>  
            @foreach($data['zones'] as $t=>$count)
              <a href="{{ route('College.index')}}?zone={{$t}}" class="btn font-weight-bold btn-light-warning mr-2 mb-2">{{$t}} <span class="label label-warning ml-2">{{$count}}</span></a>   
            @endforeach
          </div>
          <!--end::Body-->
        </div>
        <!--end::List Widget 7-->   

    </div>
  </div>

  

</x-dynamic-component>