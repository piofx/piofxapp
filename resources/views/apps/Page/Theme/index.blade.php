<x-dynamic-component :component="$app->componentName" class="mt-4" >

  <!--begin::Breadcrumb-->
  <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
      <a href="/admin" class="text-muted">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
      <a href=""  class="text-muted">{{ ucfirst($app->module) }}s</a>
    </li>
  </ul>
  <!--end::Breadcrumb-->


  <div class="row">
    <div class="col-12 col-md-3">
      <!--begin::Stats Widget 13-->
      <a href="#" class="card card-custom   gutter-b" style="background:#ff5500;">
        <!--begin::Body-->
        <div class="card-body">
          <span class="svg-icon svg-icon-4x svg-icon-white ml-n2">
            <span class="svg-icon svg-icon-white svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Layout/Layout-top-panel-3.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect x="0" y="0" width="24" height="24"/>
                <path d="M3,4 L20,4 C20.5522847,4 21,4.44771525 21,5 L21,7 C21,7.55228475 20.5522847,8 20,8 L3,8 C2.44771525,8 2,7.55228475 2,7 L2,5 C2,4.44771525 2.44771525,4 3,4 Z M3,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,19 C14,19.5522847 13.5522847,20 13,20 L3,20 C2.44771525,20 2,19.5522847 2,19 L2,11 C2,10.4477153 2.44771525,10 3,10 Z" fill="#000000"/>
                <rect fill="#000000" opacity="0.3" x="16" y="10" width="5" height="10" rx="1"/>
              </g>
            </svg><!--end::Svg Icon--></span>
          </span>
          <div class="text-inverse-danger font-weight-bolder font-size-h2 mb-2 mt-5">Themes</div>
          <div class="font-weight-bold text-inverse-danger font-size-sm">Simple, Modular & Developer Friendly</div>
        </div>
        <!--end::Body-->
      </a>
      <!--end::Stats Widget 13-->
      <!--begin::List Widget 1-->
      <div class="card card-custom gutter-b">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
          <h3 class="card-title ">
            <span class="card-label font-weight-bolder text-dark">Menu</span>
          </h3>

        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body pt-8">
          <!--begin::Item-->
          <div class="d-flex align-items-center mb-10 ">
            <!--begin::Symbol-->
            <div class="symbol symbol-40 symbol-light-primary mr-5">
              <span class="symbol-label">
                <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Thunder-move.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"/>
                    <path d="M16.3740377,19.9389434 L22.2226499,11.1660251 C22.4524142,10.8213786 22.3592838,10.3557266 22.0146373,10.1259623 C21.8914367,10.0438285 21.7466809,10 21.5986122,10 L17,10 L17,4.47708173 C17,4.06286817 16.6642136,3.72708173 16.25,3.72708173 C15.9992351,3.72708173 15.7650616,3.85240758 15.6259623,4.06105658 L9.7773501,12.8339749 C9.54758575,13.1786214 9.64071616,13.6442734 9.98536267,13.8740377 C10.1085633,13.9561715 10.2533191,14 10.4013878,14 L15,14 L15,19.5229183 C15,19.9371318 15.3357864,20.2729183 15.75,20.2729183 C16.0007649,20.2729183 16.2349384,20.1475924 16.3740377,19.9389434 Z" fill="#000000"/>
                    <path d="M4.5,5 L9.5,5 C10.3284271,5 11,5.67157288 11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L4.5,8 C3.67157288,8 3,7.32842712 3,6.5 C3,5.67157288 3.67157288,5 4.5,5 Z M4.5,17 L9.5,17 C10.3284271,17 11,17.6715729 11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L4.5,20 C3.67157288,20 3,19.3284271 3,18.5 C3,17.6715729 3.67157288,17 4.5,17 Z M2.5,11 L6.5,11 C7.32842712,11 8,11.6715729 8,12.5 C8,13.3284271 7.32842712,14 6.5,14 L2.5,14 C1.67157288,14 1,13.3284271 1,12.5 C1,11.6715729 1.67157288,11 2.5,11 Z" fill="#000000" opacity="0.3"/>
                  </g>
                </svg><!--end::Svg Icon--></span>
              </span>
            </div>
            <!--end::Symbol-->
            <!--begin::Text-->
            <div class="d-flex flex-column font-weight-bold ">
              <a href="{{ route('Theme.index')}}" class="text-dark text-hover-primary mb-1 font-size-lg">Listing</a>
              <span class="text-muted">All themes</span>
            </div>
            <!--end::Text-->
          </div>
          <!--end::Item-->
            <!--begin::Item-->
          <div class="d-flex align-items-center mb-10">
            <!--begin::Symbol-->
            <div class="symbol symbol-40 symbol-light-success mr-5">
              <span class="symbol-label">
                <span class="svg-icon svg-icon-success svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Code/CMD.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"/>
                    <path d="M9,15 L7.5,15 C6.67157288,15 6,15.6715729 6,16.5 C6,17.3284271 6.67157288,18 7.5,18 C8.32842712,18 9,17.3284271 9,16.5 L9,15 Z M9,15 L9,9 L15,9 L15,15 L9,15 Z M15,16.5 C15,17.3284271 15.6715729,18 16.5,18 C17.3284271,18 18,17.3284271 18,16.5 C18,15.6715729 17.3284271,15 16.5,15 L15,15 L15,16.5 Z M16.5,9 C17.3284271,9 18,8.32842712 18,7.5 C18,6.67157288 17.3284271,6 16.5,6 C15.6715729,6 15,6.67157288 15,7.5 L15,9 L16.5,9 Z M9,7.5 C9,6.67157288 8.32842712,6 7.5,6 C6.67157288,6 6,6.67157288 6,7.5 C6,8.32842712 6.67157288,9 7.5,9 L9,9 L9,7.5 Z M11,13 L13,13 L13,11 L11,11 L11,13 Z M13,11 L13,7.5 C13,5.56700338 14.5670034,4 16.5,4 C18.4329966,4 20,5.56700338 20,7.5 C20,9.43299662 18.4329966,11 16.5,11 L13,11 Z M16.5,13 C18.4329966,13 20,14.5670034 20,16.5 C20,18.4329966 18.4329966,20 16.5,20 C14.5670034,20 13,18.4329966 13,16.5 L13,13 L16.5,13 Z M11,16.5 C11,18.4329966 9.43299662,20 7.5,20 C5.56700338,20 4,18.4329966 4,16.5 C4,14.5670034 5.56700338,13 7.5,13 L11,13 L11,16.5 Z M7.5,11 C5.56700338,11 4,9.43299662 4,7.5 C4,5.56700338 5.56700338,4 7.5,4 C9.43299662,4 11,5.56700338 11,7.5 L11,11 L7.5,11 Z" fill="#000000" fill-rule="nonzero"/>
                  </g>
                </svg><!--end::Svg Icon--></span>
              </span>
            </div>
            <!--end::Symbol-->
            <!--begin::Text-->
            <div class="d-flex flex-column font-weight-bold">
              <a href="{{ route('Template.public_index')}}" class="text-dark text-hover-primary mb-1 font-size-lg">Templates</a>
              <span class="text-muted">HTML</span>
            </div>
            <!--end::Text-->
          </div>
          <!--end::Item-->
         
        

        </div>
        <!--end::Body-->
      </div>
      <!--end::List Widget 1-->

      <!--begin::upload element-->
      <div class="card card-custom bgi-no-repeat  gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('/themes/metronic/media/svg/patterns/abstract-4.svg') }}">
        <div class="card-body">
          <a href="#" class="card-title font-weight-bold text-muted text-hover-primary font-size-h5">New Theme Upload </a>
          <div class="font-weight-bold text-success mt-2 mb-5">Upload only zip files</div>
          <form method="post" action="{{route('Theme.upload',$app->id)}}" enctype="multipart/form-data">
            <input type="file" class="form-control-file" name="file" id="exampleFormControlFile1" multiple>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
            <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
            <button type="submit" class="btn btn-warning mt-4"><i class="la la-cloud"></i> Upload</button>
          </form>
        </div>
      </div>
      <!--end::upload element-->

    </div>

    <div class="col-12 col-md-9">
      <!--begin::Stats Widget 4-->
      <div class="card card-custom gutter-b bg-warning-o-50  " style="border:1px solid #ecd7bc">
        <div class="row">
          <div class="col-12 col-md-2">
            @if(Storage::disk('s3')->exists('themes/'.request()->get('client.theme.id').'/file_preview.jpg'))
            <div class="pr-8">
            <img src="{{ Storage::disk('s3')->url('themes/'.request()->get('client.theme.id').'/file_preview.jpg')}}" class="w-100 m-8 border rounded"/>
            </div>
              @elseif(Storage::disk('s3')->exists('themes/'.request()->get('client.theme.id').'/file_preview.png'))
               <img src="{{ Storage::disk('s3')->url('themes/'.request()->get('client.theme.id').'/file_preview.png')}}" class="w-100 p-8"/>
                @else
                <img src="{{ asset('img/theme/themedefault.png')}}" class="w-100 p-8"/>
                @endif
            
            </div>
            <div class="col-12 col-md-10">
             <!--begin::Body-->
             <div class="pl-0 card-body  d-flex align-items-center py-0 mt-1 ">
              <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                <span class="font-weight-bold text-muted font-size-lg">Current Theme</span>
                <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-2 text-hover-primary">{{ ucfirst(client('theme'))}}</a>
                  @if(request()->get('client.theme.active'))
                  <span class="text-success">Active</span>
                  @else
                  <span class="text-warning">Inactive</span>
                  @endif
                </div>
                <div class="btn-group" role="group" aria-label="First group">
                  <a href="{{ route('Theme.show',request()->get('client.theme.id'))}}"  class="btn btn-primary "><i class="la la-eye"></i> view</a>
                  @if(\Auth::user()->isAdmin())
                  <a href="{{ route('Theme.edit',request()->get('client.theme.id'))}}"  class="btn btn-success "><i class="la la-gear"></i> Settings</a>

                  <button type="button" class="btn btn-warning "><i class="la la-files-o"></i> Data</button>
                  @endif
                </div>
              </div>

              <!--end::Body-->
            </div>
          </div>
        </div>
        <!--end::Stats Widget 4-->

        <!--begin::Advance Table Widget 3-->
                <div class="card card-custom gutter-b">
                  <!--begin::Header-->
                  <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                      <span class="card-label font-weight-bolder text-dark">Listing</span>
                      <span class="text-muted mt-3 font-weight-bold font-size-sm">All Themes</span>
                    </h3>
                    <div class="card-toolbar">
                       <form class="form" action="{{ route('Theme.index')}}" method="get">
                      <div class="input-icon">
           <input type="text" class="form-control mr-5" name="item" placeholder="Search..." @if(request()->get('item')) value="{{request()->get('item')}}" @endif style="max-width:150px"/>
           <span><i class="flaticon2-search-1 icon-md"></i></span>
         </div>
       </form>
                      <a href="{{ route('Theme.create')}}" class="btn btn-outline-success font-weight-bolder font-size-sm">
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
                              <span class="text-dark-75">Themes</span>
                            </th>
                            <th style="min-width: 100px">Created</th>
                            <th style="min-width: 130px">Status</th>
                            <th style="min-width: 120px" class="float-right text-right">Tools</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($objs as $key=>$obj)  
                          <tr>
                            <td class="pl-0 py-8">
                              <div class="d-flex align-items-center">
                                <div class="symbol symbol-50 flex-shrink-0 mr-4">
                                  @if(Storage::disk('s3')->exists('themes/'.$obj->id.'/file_preview.jpg'))
                                  <div class="symbol-label" style="background-image: url('{{ Storage::disk('s3')->url('themes/'.$obj->id.'/file_preview.jpg')}}')"></div>
                                  @elseif(Storage::disk('s3')->exists('themes/'.$obj->id.'/file_preview.png'))
                                  <div class="symbol-label" style="background-image: url('{{ Storage::disk('s3')->url('themes/'.$obj->id.'/file_preview.png')}}')"></div>
                                  @else
                                  <div class="symbol-label" style=""></div>
                                  @endif
                                  
                                </div>
                                <div>
                                  <a href="{{ route('Theme.show',$obj->id)}}" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$obj->name}}</a>@if(request('client.theme.id')==$obj->id)
                  <span class='label label-lg label-light-info label-inline'>current</span>
                  @endif
                                  <span class="text-muted font-weight-bold d-block">{{$obj->slug}}</span>
                                </div>
                              </div>
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
                              <a href="{{ route('Theme.page',$obj->id) }}" class="btn  btn-light btn-hover-primary btn-sm mr-3" >
                                <span class="svg-icon svg-icon-primary svg-icon-2x" ><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Devices/Display3.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <polygon fill="#000000" opacity="0.3" points="5 7 5 15 19 15 19 7"/>
        <path d="M11,19 L11,16 C11,15.4477153 11.4477153,15 12,15 C12.5522847,15 13,15.4477153 13,16 L13,19 L14.5,19 C14.7761424,19 15,19.2238576 15,19.5 C15,19.7761424 14.7761424,20 14.5,20 L9.5,20 C9.22385763,20 9,19.7761424 9,19.5 C9,19.2238576 9.22385763,19 9.5,19 L11,19 Z" fill="#000000" opacity="0.3"/>
        <path d="M5,7 L5,15 L19,15 L19,7 L5,7 Z M5.25,5 L18.75,5 C19.9926407,5 21,5.8954305 21,7 L21,15 C21,16.1045695 19.9926407,17 18.75,17 L5.25,17 C4.00735931,17 3,16.1045695 3,15 L3,7 C3,5.8954305 4.00735931,5 5.25,5 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg><!--end::Svg Icon--></span> Preview
                              </a>
                              <a href="{{ route('Theme.show',$obj->id)}}" class="btn btn-light btn-hover-primary btn-sm">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                  <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                      <polygon points="0 0 24 0 24 24 0 24" />
                                      <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                      <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                    </g>
                                  </svg>
                                  <!--end::Svg Icon-->
                                </span>
                              </a>
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

    </div>
  </div>


</x-dynamic-component>