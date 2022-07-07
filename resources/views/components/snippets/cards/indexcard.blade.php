
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
       @if(\Auth::user()->isAdmin())
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