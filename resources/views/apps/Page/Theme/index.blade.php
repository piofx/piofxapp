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

  <!--begin::Tiles Widget 13-->
  <div class="card card-custom bgi-no-repeat gutter-b" style="height: 225px; background-color: #663259; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url({{ asset('themes/metronic/media/svg/patterns/taieri.svg') }}">
    <!--begin::Body-->
    <div class="card-body d-flex align-items-center">
      <div>
        <h1 class="text-white font-weight-bolder line-height-lg mb-0">{{ ucfirst(client('theme'))}}</h1>
        <h5 class="mb-4"><span class="badge badge-warning">Current theme</span></h5>

        <a href="{{ route($app->module.'.show',$app->current_theme_id) }}" class="btn btn-success font-weight-bold px-6 py-3">Configure</a>
      </div>
    </div>
    <!--end::Body-->
  </div>
  <!--end::Tiles Widget 13-->

  <!--begin::Indexcard-->
  <x-snippets.cards.indexcard title="Themes"  :module="$app->module" :action="route($app->module.'.index')"  />
  <!--end::Indexcard-->

  <div class="row">
    <div class="col-12 col-md-6">
       <div class="card mb-4">
        <div class='card-body'>
           <form method="post" action="{{route('Theme.upload',$app->id)}}" enctype="multipart/form-data">
                
                <div class="">
                     <div class="">
                      <button type="submit" class="btn btn-success  float-right font-weight-bold">upload</button>
                      <label for="exampleFormControlFile1">Select Theme Zip file</label>
                      <input type="file" class="form-control-file" name="file" id="exampleFormControlFile1" multiple>
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                      <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
                      <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">

                    </div>
                </div>
                
                </form>
        </div>
      </div>

    </div>
    <div class="col-12 col-md-6">
      <div class="card mb-4">
        <div class='card-body'>
          <h4>Theme Library</h4>
          <a href="{{ route('Theme.library')}}" class='btn btn-outline-primary'>Open</a>
        </div>
      </div>
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
                <th scope="col">Name </th>
                <th scope="col">Image </th>
                <th scope="col">Slug</th>
                <th scope="col">Created </th>
              </tr>
            </thead>
            <tbody>
              @foreach($objs as $key=>$obj)  
              <tr>
                <th scope="row">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route($app->module.'.show',$obj->id) }}">
                  {{ $obj->name }}
                  </a>

                  <a href=" {{ route('Theme.page',$obj->id) }}" class="badge badge-info float-right" target="_blank">
                  preview
                  </a>

                  @if(request('client.theme.id')==$obj->id)
                  <span class='badge badge-warning'>current</span>
                  @endif
                 

                </td>
                <td>
                @if(Storage::disk('public')->exists('themes/'.$obj->id.'/file_'.$obj->id.'_preview.jpg'))
                <img src="{{ Storage::disk('local')->url('themes/'.$obj->id.'/file_'.$obj->id.'_preview.jpg')}}" style="width:10em;border:2px solid silver;border-radius:4px"/>
                @endif
                </td>
                <td>{{ $obj->slug }}</td>
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
        {{$objs->appends(request()->except(['page','search']))->links()  }}
      </nav>
  </x-snippets.cards.basic>
  <!--end::basic card-->
</x-dynamic-component>