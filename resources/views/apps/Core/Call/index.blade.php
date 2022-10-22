<x-dynamic-component :component="$app->componentName" class="mt-4" >

  

  <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->

  <!--begin::Indexcard-->
  <div class="card mb-4">
  <div class="card-body bg-light">
    @if(\Auth::user())
      @if(\Auth::user()->isAdmin())
      <a href="/admin/call/upload" class="btn btn-primary float-right">Upload Data</a>
      @endif
    @endif
    <h2 class="card-title mb-0">Call Statistics</h2>
  </div>
</div>
  <!--end::Indexcard-->

  <!--begin::basic card-->
  <x-snippets.cards.basic>
        Filters: <a href="{{ route('Call.index')}}"><span class="badge badge-light">This Month</span></a> <a href="{{ route('Call.index')}}?filter=lastmonth"><span class="badge badge-light">Last Month</span></a> <a href="{{ route('Call.index')}}?filter=overall"><span class="badge badge-light">Over All</span></a>
        <hr>
        <h3>All Callers <span class="badge badge-primary">@if(request()->get('filter')) {{request()->get('filter') }} @else thismonth @endif</span></h3>

        <div class="table-responsive mb-5">
          <table class="table table-bordered mb-0">
            <thead>
              <tr class="">
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Unique <br>Customers</th>
                <th scope="col">Interacted <br>Calls</th>
                <th scope="col">Avg <br>Talktime</th>
                <th scope="col">Total <br>Talktime</th>
                <th scope="col">Admissions</th>
                <th scope="col">Performance <br>Score</th>
              </tr>
            </thead>
            <tbody class="{{$k=1}}">
              @foreach($data['all'] as $user=>$d) 

              <tr class="@if($k<4)bg-light-warning @endif">
                <th scope="row">{{ $k++ }}</th>
                <td><b>{{ $user }}</b> @if($k<5) <span class="badge badge-warning">Top Performer</span>@endif</td>
                  <td>{{ $d['users'] }}</td>
                <td>@if(isset($d['answered'])) {{ ($d['contacted']+$d['answered'] )}} @else {{$d['contacted']}} @endif</td>
                
                <td>{{ $d['avg_talktime'] }}</td>
                <td>{{ $d['total_talktime'] }}</td>
                <td>{{ $d['admission'] }}</td>
                <td>{{ $d['score'] }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>

        <h3>Centers</h3>

        <div class="table-responsive mb-5">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Unique <br>Customers</th>
                <th scope="col">Interacted <br>Calls</th>
                <th scope="col">Avg <br>Talktime</th>
                <th scope="col">Total <br>Talktime</th>
                <th scope="col">Admissions</th>
                <th scope="col">Average <br>Score</th>
              </tr>
            </thead>
            <tbody class="{{$k=1}}">
              @foreach($data['center'] as $user=>$d) 

              <tr class="@if($k<2)bg-light-info @endif">
                <th scope="row">{{ $k++ }}</th>
                <td><b>{{ $user }}</b> @if($k<3) <span class="badge badge-info">Top Performer</span>@endif</td>
                <td>{{ $d['users'] }}</td>
                <td>@if(isset($d['answered'])) {{ $d['answered'] }} @else 0 @endif</td>
                <td>@if(isset($d['employees']) && $d['employees']!=0) {{ $obj->getTime(round($d['avg_duration']/$d['employees'],2)) }} @else 0 @endif </td>
                <td>{{ $obj->getTime($d['total_duration']) }}</td>
                <td>{{ $d['admission'] }}</td>
                <td>{{ $d['score'] }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>

        
       
     
  </x-snippets.cards.basic>
  <!--end::basic card-->

</x-dynamic-component>