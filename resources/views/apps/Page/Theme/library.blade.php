<x-dynamic-component :component="$app->componentName" class="mt-4" >

  <!--begin::Breadcrumb-->
  <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
      <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
      <a href="{{ route('Theme.index')}}" class="text-muted">Themes</a>
    </li>
    <li class="breadcrumb-item">
      <a href=""  class="text-muted">Library</a>
    </li>
  </ul>
  <!--end::Breadcrumb-->



  <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->



  <!--begin::Indexcard-->
  <x-snippets.cards.indexcard title="Theme Library"  :module="$app->module" :action="route($app->module.'.index')"  />
  <!--end::Indexcard-->



  
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