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
    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-success">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                <div class="d-flex align-items-center">
                    <a href="#" class="h2 text-dark text-hover-primary mb-0">
                        Users
                    </a> 
                    @if(Auth::user()->checkRole(['superadmin','agencyadmin','clientadmin']))
                        <a href="{{ route($app->module.'.settings') }}" class="btn btn-warning btn-sm ml-2"  >
                            <i class="fa fa-cog p-0"></i> 
                        </a>
                    @endif
                </div>
                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                    <!--begin::Form-->
                    <form class="form" action="{{ route($app->module.'.search') }}" method="get">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="item" placeholder="Search..." @if(request()->get('item')) value="{{request()->get('item')}}" @endif style="max-width:150px"/>
                                    <span><i class="flaticon2-search-1 icon-md"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <a href="{{ route($app->module.'.create') }}" class="btn btn-primary mt-1 mt-md-0"  >
                                    <i class="flaticon-plus"></i> Create Record
                                </a>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>

  <!--end::Indexcard-->
  <!--begin::upload element-->
<div class="card card-custom bgi-no-repeat  gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('/themes/metronic/media/svg/patterns/abstract-4.svg') }}">
        <div class="row pl-5">
        <div class="col-5  ml-10">
          <div class="card-body">
            <a href="#" class="card-title font-weight-bold text-muted text-hover-primary font-size-h5">Add Users</a>
            <div class="font-weight-bold text-success mt-2 mb-2">Upload CSV file In The Sample Format Only</div>
            <div class="font-weight-bold text-primary mt-2 mb-2">Download The Sample Format Of CSV File
            <a href="{{ route($app->module.'.samplecsv') }}" class="btn btn-info btn-sm ml-2"><i class="fa fa-download p-0"></i></a>
            </div>
            <form method="post" action="{{route($app->module.'.upload')}}" enctype="multipart/form-data">
              <input type="file" class="form-control-file" name="file" id="exampleFormControlFile1" multiple>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
              <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
              <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
              <button type="submit" name="submit" class="btn btn-warning mt-4"><i class="la la-cloud"></i> Upload</button>
            </form>
          </div>
          </div>
          <div class="col-6">
          <div class="mt-8">
          <a href="#" class="card-title font-weight-bold text-muted text-hover-primary font-size-h5">Download Users Data</a><br>
          <a href="{{ route($app->module.'.download')}}" class="text-muted"><button class="btn btn-danger mt-4"><i class="la la-download"></i>Download</button></a>
          </div>
          </div>
        </div>
      </div>
      <!--end::upload element-->

  <!--begin::basic card-->
  <x-snippets.cards.basic>
  <div class="row">
      <div class="col-10">
        @if($objs->total()!=0)
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                  <tr>
                    <th scope="col">#({{$total}})</th>
                    <th scope="col">Name </th>
                    <th scope="col">Email / Phone</th>
                    <th scope="col">Details</th>
                    <th scope="col">Created</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  @foreach($objs as $key=>$obj)  
                  <tr>
                    <th scope="row">{{$i++}}</th>
                    <td>
                      <a href=" {{ route($app->module.'.show',$obj->id) }} ">
                      {{ $obj->name }}
                      </a>
                    </td>
                    <td>{{ $obj->email }}<br>{{$obj->phone}}</td>
                    
                    <td>{!! $obj->data !!}</td>
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
        {{$objs->appends(['status'=>request()->get('status'),'user_id'=>request()->get('user_id'),'tag'=>request()->get('tag'),'category'=>request()->get('category'),'date_filter'=>request()->get('date_filter')])->links()  }}
      </nav>
     </div>

      <div class="col-2 px-0">
        <div class="rounded bg-light-danger p-5 border-0">
			<h3 class="input-label text-dark">Filter By</h3>
			<form action="{{ route($app->module.'.search') }}" method="GET">
				<input type="text" name="group" class="form-control mt-3" placeholder="Group....">
				<input type="text" name="subgroup" class="form-control mt-3" placeholder="Sub Group....">
				<div class="mt-3">
					<button type="submit" class="btn btn-danger font-weight-bolder">Filter</button>
				</div>
			</form>
          </div>
       </div>

    </div>
  </x-snippets.cards.basic>
  <!--end::basic card-->
</x-dynamic-component>