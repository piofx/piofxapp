<x-dynamic-component :component="$app->componentName" class="mt-4" >

  

  <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->

<div class="row">
  <div class="col-12 col-md-10">
  <!--begin::Indexcard-->
  <div class="card mb-4">
  <div class="card-body bg-light">
    @if(\Auth::user())
      @if(\Auth::user()->isAdmin())
      <a href="/admin/call/upload" class="btn btn-primary float-right">Upload Data</a>
      @endif
    @endif
    <h2 class="card-title mb-0">Counsellors Dashboard</h2>
  </div>
</div>
  <!--end::Indexcard-->


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
                <td>@if(isset($d['answered']) && isset($d['contacted'])) 
                      {{ ($d['contacted']+$d['answered'] )}} 
                    @elseif(isset($d['answered'])) 
                      {{$d['answered']}} 
                    @else 
                      {{$d['contacted']}} 
                    @endif
                </td>
                <td>{{ $d['avg_talktime'] }}</td>
                <td>{{ $d['total_talktime'] }}</td>
                <td>{{ $d['admission'] }}</td>
                <td>{{ $d['score'] }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        
        <h3 class="mt-4">Centers</h3>

        <div class="table-responsive mb-5">
          <table class="table table-bordered mb-5">
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

          <span class="text-primary">Performance Score = (Unique Customers * Avg Talktime in minutes) + (admissions * 100)</span>
        </div>

    </div>
    <div class="col-12 col-md-2">
      <h3 class="mt-5 mt-md-0">Menu</h3>
      <div class="list-group">
        <div class="list-group">
        <a href="{{ route('Call.index')}}" class="list-group-item list-group-item-action active">
          Dashboard
        </a>
        <a href="{{ route('Call.documents')}}" class="list-group-item list-group-item-action">Documents</a>
        <a href="{{ route('Call.tutorials')}}" class="list-group-item list-group-item-action ">Tutorials</a>
      </div>
    </div>
  </div>
       


</x-dynamic-component>