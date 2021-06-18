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

        <!--begin::Advance Table Widget 3-->
                <div class="card card-custom gutter-b">
                  <!--begin::Header-->
                  <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                      <span class="card-label font-weight-bolder text-dark">Pages</span>
                      <span class="text-muted mt-3 font-weight-bold font-size-sm">Static Content</span>
                    </h3>
                    <div class="card-toolbar">
                       <form class="form" action="{{ route('Page.index',$app->id)}}" method="get">
                      <div class="input-icon">
           <input type="text" class="form-control mr-5" name="item" placeholder="Search..." @if(request()->get('item')) value="{{request()->get('item')}}" @endif style="max-width:150px"/>
           <span><i class="flaticon2-search-1 icon-md"></i></span>
         </div>
       </form>
                      <a href="{{ route('Page.create',$app->id)}}" class="btn btn-outline-success font-weight-bolder font-size-sm">
                      <span class="svg-icon "><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
        <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
    </g>
</svg><!--end::Svg Icon--></span>New</a>
                    </div>
                  </div>
                  <!--end::Header-->
                  <!--begin::Body-->
                  <div class="card-body pt-0 pb-3">
                    <!--begin::Table-->
                    <div class="table-responsive">
                      <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                        <thead>
                          <tr class="text-uppercase">
                            <th style="min-width: 250px" class="pl-7">
                              <span class="text-dark-75">Page</span>
                            </th>
                            <th style="min-width: 250px" class="pl-7">
                              <span class="text-dark-75">slug</span>
                            </th>
                            <th style="min-width: 100px">Created</th>
                            <th style="min-width: 130px">Status</th>
                            <th style="min-width: 120px" class="float-right text-right">Tools</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($objs as $key=>$obj)  
                          <tr>
                            <td class="pl-0 ">
                              
                                  <a href="{{ route('Page.show',[$app->id,$obj->id])}}" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg ml-3">{{$obj->name}}</a>@if(request('client.theme.id')==$obj->id)
                  <span class='label label-lg label-light-info label-inline'>current</span>
                  @endif
                                </div>
                              </div>
                            </td>
                            <td>
                              <span class="text-muted font-weight-bold">{{$obj->slug}}</span>
                            </td>
                            <td>
                              <span class="text-muted font-weight-bold">{{ ($obj->created_at) ? $obj->created_at->diffForHumans() : '' }}</span>
                            </td>
                           
                            
                            
                            <td>
                              @if($obj->status)
                              <span class="label label-lg label-light-success label-inline">Active</span>
                              @else
                              <span class="label label-lg label-light-warning label-inline">Inactive</span>
                              @endif
                            </td>

                            <td class="text-right pr-0">
                              <div class="d-flex  float-right">
                         <!-- View Button -->
                        <form action="{{ route('Page.show',[$app->id,$obj->id]) }}">
                            <button type="submit" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2"><i class="fas fa-eye m-0"></i></button>
                        </form>
                        <!-- End View Button -->
                        <!-- Edit Button -->
                        <form action="{{ route('Page.edit',[$app->id,$obj->id]) }}">
                            <button type="submit" class="btn btn-sm btn-default btn-text-primary btn-hover-success btn-icon mr-2"><i class="fas fa-edit m-0"></i></button>
                        </form>
                        <!-- End Edit Button -->

                        <!-- Confirm Delete Modal Trigger -->
                        <a href="#" data-toggle="modal" class="btn btn-sm btn-default btn-text-primary btn-hover-danger btn-icon mr-2" data-target="#staticBackdrop-{{$obj->id}}"><i class="fas fa-trash-alt m-0"></i></a>
                        <!-- End Confirm Delete Modal Trigger -->

                        <!-- Confirm Delete Modal -->
                        <div class="modal fade" id="staticBackdrop-{{$obj->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Confirm Delete</h5>
                                    <button type="button" class="btn btn-xs btn-icon btn-soft-secondary" data-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" width="10" height="10" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                                    </svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Do you want to delete this permanently?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <form action="{{ route('Page.destroy', [$app->id,$obj->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Confirm Delete Modal -->
                    </div>
                             
                            </td>
                          </tr>
                          @endforeach
                          
                        </tbody>
                      </table>
                    </div>
                    <!--end::Table-->
                  </div>
                  <!--end::Body-->
                </div>
                <!--end::Advance Table Widget 3-->
                  <nav aria-label="Page navigation  " class="card-nav @if($objs->total() > config('global.no_of_records'))mt-3 @endif">
        {{$objs->appends(['status'=>request()->get('status')])->links()  }}
      </nav>



</div>

</div>  
</x-dynamic-component>