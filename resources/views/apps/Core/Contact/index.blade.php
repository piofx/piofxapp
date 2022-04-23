<x-dynamic-component :component="$app->componentName" class="mt-4" >

  <!--begin::Breadcrumb-->
  <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
      <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
      <a href="{{ route('Contact.index')}}"  class="text-muted">{{ ucfirst($app->module) }}</a>
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
   <div class="d-flex flex-column mr-5">
    <div class="h2 text-dark  mb-0">
    Contact Form
    @if(Auth::user()->checkRole(['superadmin','agencyadmin','clientadmin']))
      <a href="{{ route('Contact.settings') }}" class="btn btn-warning btn-sm mt-1 mt-md-0"  >
        <i class="flaticon-settings p-0"></i> 
      </a>
    @endif

    @if(Auth::user()->checkRole(['superadmin','agencyadmin','clientadmin','clientmanager']))
    <a href="{{ route('Contact.index') }}?export=1{{$url_suffix}}" class="btn btn-info btn-sm mt-1 mt-md-0"  >
        <i class="flaticon-download p-0"></i> 
    </a>
    @endif

      <a href="{{ route('Contact.create') }}" class="btn btn-primary btn-sm mt-1 mt-md-0"  >
        <i class="flaticon-plus"></i> Create 
      </a>
       <a href="{{ route('Contact.admin.statistics') }}" class="btn btn-danger btn-sm mt-1 mt-md-0"  >
         Statistics 
      </a>
    </div> 
    @if(request()->get('user_id'))
    @foreach($users as $user)
      @if(request()->get('user_id')==$user->id)
      <div class="mb-3">User: 
        <span class="label label-light-light label-pill text-dark label-inline">{{$user->name}}</span>
      </div>
      @endif
    @endforeach
    @endif
    @if(request()->get('status')!=null)
    <div class="mb-3">Filter: 
      @if(request()->get('status')==0)
      <span class="label label-light-success label-pill label-inline">Customer</span>
      @elseif(request()->get('status')==1)
      <span class="label label-light-warning label-pill label-inline">Open Lead</span>
      @elseif(request()->get('status')==2)
      <span class="label label-light-danger label-pill label-inline">Cold Lead</span>
      @elseif(request()->get('status')==3)
      <span class="label label-light-info label-pill label-inline">Warm Lead</span>
      @elseif(request()->get('status')==4)
      <span class="label label-light-primary label-pill label-inline">Prospect</span>
      @elseif(request()->get('status')==5)
      <span class="label label-light-light label-pill text-dark label-inline">Not Responded</span>
      @endif

      
    </div>
    @endif

    @if(request()->get('tag'))
    <div class="mb-3">Filter Tag: 
      <span class="label label-light-light label-pill text-dark label-inline">{{request()->get('tag')}} </span>
      </div>
      @endif

      @if(request()->get('date_filter'))
    <div class="mb-3">Date Filter : 
      <span class="label label-light-light label-pill text-dark label-inline">{{request()->get('date_filter')}} </span>
      </div>
      @endif
      @if(request()->get('category'))
    <div class="mb-3">Category : 
      <span class="label label-light-light label-pill text-dark label-inline">{{request()->get('category')}} </span>
      </div>
      @endif
    @if(request()->get('status')!=null || request()->get('user_id') || request()->get('tag') || request()->get('date_filter') || request()->get('category'))
    <a href="{{ route('Contact.index') }} "><i class="fa flaticon2-left-arrow text-primary"></i> back</a>
    @endif
   </div>
   <div class="ml-8 ml-lg-0 ml-xxl-8 flex-shrink-0">
    <!--begin::Form-->
    <form class="form" action="{{ route('Contact.index') }}" method="get">
      <div class="row">
        <div class="col-12 " >
         <div class="input-icon">
           <input type="text" class="form-control" name="item" placeholder="Search..." @if(request()->get('item')) value="{{request()->get('item')}}" @endif style="max-width:250px"/>
           <span><i class="flaticon2-search-1 icon-md"></i></span>
         </div>
       </div>
         
      </div>
    </form>
    <!--end::Form-->
   </div>
  </div>
 </div>
</div>
<!--end::Indexcard-->

@if(request()->get('status')==null)
  <div class="row mb-5">
    <div class="col-6 col-md-2" >
      <x-snippets.cards.basic class="bg-light-warning border border-warning mb-5">
        <h5>Open Leads <a href="#" data-toggle="tooltip" title="Candidates who are yet to be contacted"><i class="flaticon-exclamation-2"></i></a></h5>
        <div class="display-3">
          <a href="{{ route('Contact.index')}}?status=1{{$url_suffix}}">{{ count($data['overall'][1])}}</a>
        </div>
      </x-snippets.cards.basic>
    </div>
    <div class="col-6 col-md-2">
      <x-snippets.cards.basic class="border border-dark mb-5">
        <h5 class="">Not Responded </h5>
        <div class="display-3">
          <a href="{{ route('Contact.index')}}?status=5{{$url_suffix}}">{{ count($data['overall'][5]) }}</a>
        </div>
      </x-snippets.cards.basic>
    </div>
    <div class="col-6 col-md-2">
        <x-snippets.cards.basic class="bg-light-danger border border-danger mb-5">
        <h5>Cold Leads <a href="#" data-toggle="tooltip" title="Candidates who will not join our program"><i class="flaticon-exclamation-2"></i></a></h5>
        <div class="display-3">
          <a href="{{ route('Contact.index')}}?status=2{{$url_suffix}}">{{ count($data['overall'][2])}}</a>
        </div>
      </x-snippets.cards.basic>
    </div>
    <div class="col-6 col-md-2" >
        <x-snippets.cards.basic class="bg-light-info border border-info mb-5">
        <h5>Warm Leads <a href="#" data-toggle="tooltip" title="Candidates who may join our program in near future"><i class="flaticon-exclamation-2"></i></a></h5>
        <div class="display-3">
          <a href="{{ route('Contact.index')}}?status=3{{$url_suffix}}">{{ count($data['overall'][3])}}</a>
        </div>
      </x-snippets.cards.basic>
    </div>
    <div class="col-6 col-md-2">
        <x-snippets.cards.basic class="bg-light-primary  border border-primary mb-5">
        <h5>Prospects <a href="#" data-toggle="tooltip" title="Candidates who are willing to take our program"><i class="flaticon-exclamation-2"></i></a></h5>
        <div class="display-3">
          <a href="{{ route('Contact.index')}}?status=4{{$url_suffix}}">{{ count($data['overall'][4])}}</a>
        </div>
      </x-snippets.cards.basic>
    </div>
    <div class="col-6 col-md-2">
        <x-snippets.cards.basic class="bg-light-success border border-success mb-5">
        <h5>Customers <a href="#" data-toggle="tooltip" title="Candidates who made the purchase"><i class="flaticon-exclamation-2"></i></a></h5>
        <div class="display-3">
          <a href="{{ route('Contact.index')}}?status=0{{$url_suffix}}">{{ count($data['overall'][0])}}</a>
        </div>
      </x-snippets.cards.basic>
    </div>
  </div>
@else

@endif
<div class="row">
  <div class="col-12 col-md-9">
  <!--begin::basic card-->
  <x-snippets.cards.basic>
    @if($objs->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr class="bg-light">
                <th scope="col">#({{$objs->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col" style="max-width: 200px ;">Entry</th>
                <th scope="col">Created</th>
              </tr>
            </thead>
            <tbody>
              @foreach($objs as $key=>$obj)  
              <tr>
                <th scope="row">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route($app->module.'.show',$obj->id) }} ">
                  {{ $obj->name }}
                  </a><br> 
                  {{$obj->phone}}<br>
                    {{ $obj->email }} 
                      @if($obj->valid_email)
                        <i class="far fa-check-circle text-success"></i> 
                      @elseif($obj->valid_email===0)
                        <i class="far fa-times-circle text-danger"></i> 
                      @endif
                        <br>
                      @if($obj->status==0)
                  <span class="label label-light-success label-pill label-inline">Customer</span>
                  @elseif($obj->status==1)
                  <span class="label label-light-warning label-pill label-inline">Open Lead</span>
                  @elseif($obj->status==2)
                  <span class="label label-light-danger label-pill label-inline">Cold Lead</span>
                  @elseif($obj->status==3)
                  <span class="label label-light-info label-pill label-inline">Warm Lead</span>
                  @elseif($obj->status==4)
                  <span class="label label-light-primary label-pill label-inline">Prospect</span>
                  @elseif($obj->status==5)
                  <span class="label label-light-light label-pill text-dark label-inline">Not Responded</span>
                  @endif
                  <div class="mt-3">
                  <span class="label label-light label-pill label-inline">{{ $obj->category }}</span> 
                  </div>
                </td>
                  <td> 
                    <div class="">
                      <b>Message:</b><br>
                    {!! $obj->message !!}
                    </div>
                    @if($obj->comment )
                    <div class="bg-light rounded p-3 mt-3 mb-1">
                      <b>Comment by <span class="label label-light-white label-pill label-inline text-dark">{{$obj->user->name}}</span>
                        <span class="float-right text-muted"><small>{{ ($obj->created_at) ? $obj->updated_at->diffForHumans() : '' }}</small></span>
                      </b><br>
                      {!! $obj->comment !!}
                    </div>
                    @endif
                  </td>
                <td>{{ ($obj->created_at) ? $obj->created_at->diffForHumans() : '' }} </td>
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
  </x-snippets.cards.basic>
  <!--end::basic card-->
  </div>
  <div class="col-12 col-md-3 mt-5 mt-md-0">
  <!--begin::List Widget 7-->
  <div class="card card-custom gutter-b">
      <!--begin::Header-->
        <div class="card-header border-0">
          <h3 class="card-title font-weight-bolder text-dark">Team </h3>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body pt-0">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>User</th>
              <th>Count</th>
            </tr>
          </thead>
          <tbody>
          @foreach($users as $user)
            @if(isset($data['users'][$user->id]) && !request()->get('user_id'))
              <tr>
                <td><a href="{{ route('Contact.index')}}?user_id={{$user->id}}{{$url_suffix}}">{{$user->name}}</a></td>
                <td>
                  @if(isset($data['users'][$user->id]))
                  <div class="label label-light label-pill label-inline ml-3">{{ count($data['users'][$user->id])}}</div>
                  @endif
                </td>
              </tr>  
            @else
              @if(request()->get('user_id') && request()->get('user_id')==$user->id)
              <tr>
                <td><a href="{{ route('Contact.index')}}?user_id={{$user->id}}{{$url_suffix}}">{{$user->name}}</a></td>
                <td>
                  @if(isset($data['users'][$user->id]))
                  <div class="label label-light label-pill label-inline ml-3">{{ count($data['users'][$user->id])}}</div>
                  @endif
                </td>
              </tr>  
              @endif
            @endif      
          @endforeach
          </tbody>
        </table>
      </div>
      <!--end::Body-->
    </div>
    <!--end::List Widget 7-->     

@if(!request()->get('status'))
     <!--begin::List Widget 7-->
  <div class="card card-custom gutter-b">
      <!--begin::Header-->
        <div class="card-header border-0">
          <h3 class="card-title font-weight-bolder text-dark">Category </h3>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body pt-0">
        
          @foreach($data['category'] as $category =>$d)
          <a href="{{ route('Contact.index')}}?category={{$category}}{{$url_suffix}}" class="btn font-weight-bold btn-light-success mr-2 mb-2">{{$category}} <span class="label label-inline label-success ml-2">{{count($d)}}</span></a>   
            
             
           
          @endforeach
      </div>
      <!--end::Body-->
    </div>
    <!--end::List Widget 7-->   
  @endif  

@if(!request()->get('status'))
    <!--begin::List Widget 7-->
  <div class="card card-custom gutter-b">
      <!--begin::Header-->
        <div class="card-header border-0">
          <h3 class="card-title font-weight-bolder text-dark">Tags</h3>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body pt-0">
        @foreach($data['tags'] as $t=>$count)
          <a href="{{ route('Contact.index')}}?tag={{$t}}{{$url_suffix}}" class="btn font-weight-bold btn-light-warning mr-2 mb-2">{{$t}} <span class="label label-warning ml-2">{{$count}}</span></a>   
        @endforeach
      </div>
      <!--end::Body-->
    </div>
    <!--end::List Widget 7-->     
  @endif 

@if(!request()->get('status'))

<div class="card card-custom">
 <div class="card-header">
  <div class="card-title">
   <h3 class="card-title font-weight-bolder text-dark">Date Filter</h3>
  </div>
 </div>
 <div class="card-body">
        <div data-scroll="true" data-height="200">
         <a href="{{ route('Contact.index')}}?date_filter=today{{$url_suffix}}" class="btn font-weight-bold btn-light-info mr-2 mb-2">Today </a> 
          <a href="{{ route('Contact.index')}}?date_filter=yesterday{{$url_suffix}}" class="btn font-weight-bold btn-light-info mr-2 mb-2">Yesterday </a>
          <a href="{{ route('Contact.index')}}?date_filter=lastsevendays{{$url_suffix}}" class="btn font-weight-bold btn-light-success mr-2 mb-2">Last 7 days </a>
          <a href="{{ route('Contact.index')}}?date_filter=lastfifteendays{{$url_suffix}}" class="btn font-weight-bold btn-light-success mr-2 mb-2">Last 15 days </a>
          <a href="{{ route('Contact.index')}}?date_filter=thisweek{{$url_suffix}}" class="btn font-weight-bold btn-light-danger mr-2 mb-2">This week </a> <a href="{{ route('Contact.index')}}?date_filter=lastweek{{$url_suffix}}" class="btn font-weight-bold btn-light-danger mr-2 mb-2">Last week </a>   
          <a href="{{ route('Contact.index')}}?date_filter=thismonth{{$url_suffix}}" class="btn font-weight-bold btn-light-secondary text-dark mr-2 mb-2">This month </a> 
          <a href="{{ route('Contact.index')}}?date_filter=lastmonth{{$url_suffix}}" class="btn font-weight-bold btn-light-secondary text-dark mr-2 mb-2">Last month </a> 
        <a href="{{ route('Contact.index')}}?date_filter=thisyear{{$url_suffix}}" class="btn font-weight-bold btn-light-primary mr-2 mb-2">This year </a> 
        <a href="{{ route('Contact.index')}}?date_filter=lastyear{{$url_suffix}}" class="btn font-weight-bold btn-light-primary mr-2 mb-2">Last year </a> 
        </div>
 </div>
    <div class="card-footer bg-light-secondary" style="border-bottom: 1px solid silver;">
        <h5 class="card-title font-weight-bolder text-dark mb-0">Date Range </h5>
          <span class="form-text text-muted">Ex: 2021-04-25</span>
          <form action="{{ url()->current() }}" method="get">
          <div class="form-group mb-3 mt-4">
    <div class="input-group">
     <div class="input-group-prepend"><span class="input-group-text">FROM</span></div>
     <input type='text' class="form-control" id="kt_inputmask_1" name="from" placeholder="YYYY-MM-DD" @if(request()->get('from'))value="{{request()->get('from')}}" @endif/>
    </div>
    
   </div>
   <div class="form-group ">
    <div class="input-group">
     <div class="input-group-prepend"><span class="input-group-text">TO</span></div>
     <input type='text' class="form-control" id="kt_inputmask_1" name="to" placeholder="YYYY-MM-DD"  @if(request()->get('to'))value="{{request()->get('to')}}" @endif/>
    </div>
   </div>
   <input type="hidden" name="date_filter" value="generic">
   <button type="submit" class="btn btn-primary font-weight-bold mr-2">Submit</button>
 </form>  
 </div>
</div>
   
@endif
    </div>
  </div>
</x-dynamic-component>