<x-dynamic-component :component="$app->componentName" class="mt-4" >

  <!--begin::Breadcrumb-->
  <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
      <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
      <a href="{{ route('tracker')}}"  class="text-muted">{{ ucfirst($app->module) }}</a>
    </li>
  </ul>
  <!--end::Breadcrumb-->



<!--begin::Indexcard-->
<div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-success">
 <div class="card-body">
  <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
   <div class="d-flex flex-column mr-5">
    <div class="h2 text-dark  mb-0">
    User Tracker - {{$user->name}}
    </div>
    <p >{{$objs->total()}} Interactions</p>
   </div>
   <div class="ml-8 ml-lg-0 ml-xxl-8 flex-shrink-0">
   
   </div>
  </div>
 </div>
</div>
<!--end::Indexcard-->



<div class="row">
  <div class="col-12 ">
  <!--begin::basic card-->
  <x-snippets.cards.basic>
    @if($objs->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr class="bg-light">
                <th scope="col">#({{$objs->total()}})</th>
                <th scope="col">Url </th>
                <th scope="col" style="max-width: 200px ;">Data</th>
                <th scope="col">Created</th>
              </tr>
            </thead>
            <tbody>
              @foreach($objs as $key=>$obj)  
              <tr>
                <th scope="row">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href="  {{ $obj->url }} ">
                  {{ $obj->url }}
                  </a>
                </td>
                  <td> 
                    
                    @if($obj->utm_source )
                      Source : {{$obj->utm_source}} <br>
                    @endif
                     @if($obj->utm_medium )
                      Medium : {{$obj->utm_medium}} <br>
                    @endif
                     @if($obj->utm_campaign )
                      Campaign : {{$obj->utm_campaign}} <br>
                    @endif
                     @if($obj->utm_content )
                      Content : {{$obj->utm_content}} <br>
                    @endif
                     @if($obj->utm_term )
                      Term : {{$obj->utm_term}} <br>
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
  
  </div>
</x-dynamic-component>