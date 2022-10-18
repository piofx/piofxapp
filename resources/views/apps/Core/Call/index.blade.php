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
  <div class="card mb-4">
  <div class="card-body bg-light">

    <a href="/admin/call/upload" class="btn btn-primary float-right">Upload Data</a>
    <h5 class="card-title mb-0">Call Statistics</h5>
  </div>
</div>
  <!--end::Indexcard-->

  <!--begin::basic card-->
  <x-snippets.cards.basic>
    
        <h3>All Callers</h3>
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Contacted</th>
                <th scope="col">Answered</th>
                <th scope="col">Avg Talktime</th>
                <th scope="col">Total Talktime</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody class="{{$k=1}}">
              @foreach($data['all'] as $user=>$d) 

              <tr>
                <th scope="row">{{ $k++ }}</th>
                <td>{{ $user }}</td>
                <td>{{ $d['contacted'] }}</td>
                <td>{{ $d['answered'] }}</td>
                <td>{{ $d['avg_talktime'] }}</td>
                <td>{{ $d['total_talktime'] }}</td>
                <td>{!! $d['status_str'] !!}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>

        
       
     
  </x-snippets.cards.basic>
  <!--end::basic card-->

</x-dynamic-component>