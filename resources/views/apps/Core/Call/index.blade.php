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
    <h2 class="card-title mb-0"><i class="flaticon2-bell-4 text-success"></i> Counsellors Dashboard</h2>
  </div>
</div>
  <!--end::Indexcard-->

        @if(!request()->get('entity'))
        Filters: 
        <a href="{{ route('Call.index')}}?filter=today"><span class="badge badge-light">Today</span></a> 
          <a href="{{ route('Call.index')}}?filter=yesterday"><span class="badge badge-light">Yesterday</span></a> 
          <a href="{{ route('Call.index')}}?filter=thismonth"><span class="badge badge-light">This Month</span></a> 
          <a href="{{ route('Call.index')}}?filter=lastmonth"><span class="badge badge-light">Last Month</span></a> 
          
          <a href="{{ route('Call.index')}}?filter=last7days"><span class="badge badge-light">Last 7 days</span></a> 
          <a href="{{ route('Call.index')}}?filter=last30days"><span class="badge badge-light">Last 30 days</span></a> 
          <a href="{{ route('Call.index')}}?filter=overall"><span class="badge badge-light">Over All</span></a>
        <hr>
        @endif
        <h3>

            @if(!request()->get('entity'))
              All Callers 
              <span class="badge badge-primary {{date_default_timezone_set("Asia/Kolkata")}}">
              @if(request()->get('filter')) {{request()->get('filter') }} 
              @else Today  
              @endif
              </span>
              <small class="float-right d-none d-md-block">{{date("l jS \of F Y h:i:s A")}}</small>
            @else
              @if(isset($data['entity_center']))
                Center Performance
              @else
                 Counsellor Performance
              @endif

              <span class="badge badge-primary">
              {{request()->get('entity')}} 
              </span>
              <span class="badge badge-warning">
                Last 30 days
              </span>
            @endif

            
        </h3>

        @if(request()->get('entity'))
          <a href="{{ route('Call.index')}}" class="mb-4">back to dashboard</a>

          <div class="row my-4">
            <div class="col-6 col-md-3">
              <div class="card mb-3">
                <div class="card-body bg-light-warning border border-warning">
                  <h3>Excellent <br class="d-block d-md-none"> Days </h3>
                  <div class="display-3">{{$data['counter']['excellent']}}</div>
                  <small>Score > 200</small>
                </div>
              </div>
            </div>
             <div class="col-6 col-md-3">
              <div class="card mb-3">
                <div class="card-body bg-light-success border border-success">
                  <h3>High <br class="d-block d-md-none"> Days</h3>
                  <div class="display-3">{{$data['counter']['high']}}</div>
                  <small>100 > Score > 200</small>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card">
                <div class="card-body border border-dark">
                  <h3>Decent <br class="d-block d-md-none"> Days</h3>
                  <div class="display-3">{{$data['counter']['decent']}}</div>
                  <small>40 > Score > 100</small>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card">
                <div class="card-body bg-light-danger border border-danger">
                  <h3>Low <br class="d-block d-md-none"> Days</h3>
                  <div class="display-3">{{$data['counter']['low']}}</div>
                  <small>1 > Score > 40</small>
                </div>
              </div>
            </div>
          </div>
        @endif

        <div class="table-responsive mb-5">
          <table class="table table-bordered mb-0">
            <thead>
              <tr class="bg-light">
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Unique <br>Customers</th>
                <th scope="col">Interacted <br>Calls</th>
                <th scope="col">Avg <br>Talktime</th>
                <th scope="col">Total <br>Talktime</th>
                <th scope="col">Admissions</th>
                <th scope="col"> @if(isset($data['entity_center'])) Average <br>@endif Performance <br>Score</th>
              </tr>
            </thead>
            <tbody class="{{$k=1}}">
              @foreach($data['all'] as $user=>$d) 

              <tr class="@if($k<4 && !request()->get('entity') && $d['score']>30)bg-light-warning @endif 
                      @if(request()->get('entity') && $d['score']<40 && \carbon\Carbon::parse($user)->format('l')!='Sunday' && \carbon\Carbon::parse($user)->format('l')!='Saturday') 
                        bg-light-danger @endif
                        @if(request()->get('entity') && $d['score']>=200)
                        bg-light-warning
                        @endif
                        @if(request()->get('entity') && $d['score']>=100 && $d['score']<200)
                        bg-light-success
                        @endif

                        ">
                <th scope="row">{{ $k++ }}</th>
                <td>
                    @if(request()->get('entity'))
                    <b>{{ $user }}</b> 
                    @else
                    <a href="{{ route('Call.index')}}?entity={{$user}}">
                    <b>{{ $user }}</b> 
                    </a>
                    @endif

                    @if($k<5 && !request()->get('entity') && $d['score']>30) <span class="badge badge-warning">Top Performer</span>@endif

                    @if(request()->get('entity'))
                      @if(\carbon\Carbon::parse($user)->format('l')=='Sunday')
                     <span class="text-primary">{{\carbon\Carbon::parse($user)->format('l')}}</span>
                     @elseif(\carbon\Carbon::parse($user)->format('l')=='Saturday')
                     <span class="text-info">{{\carbon\Carbon::parse($user)->format('l')}}</span>
                     @else
                     <span class="text-dark">{{\carbon\Carbon::parse($user)->format('l')}}</span>
                     @endif
                    @endif
                </td>
                  <td>{{ $d['users'] }}</td>
                <td>@if(isset($d['answered']) && isset($d['contacted'])) 
                      {{ ($d['contacted']+$d['answered'] )}} 
                    @elseif(isset($d['answered'])) 
                      {{$d['answered']}} 
                    @elseif(isset($d['contacted'])) 
                      {{$d['contacted']}} 
                    @else
                      0
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
        
        @if(count($data['center'] ))
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

              <tr class="@if($k<2 && $d['score']>30)bg-light-info @endif">
                <th scope="row">{{ $k++ }}</th>
                <td>

                  @if(request()->get('entity'))
                    <b>{{ $user }}</b> 
                    @else
                    <a href="{{ route('Call.index')}}?entity={{$user}}">
                    <b>{{ $user }}</b> 
                    </a>
                  @endif

                 @if($k<3 && $d['score']>30) <span class="badge badge-info">Top Performer</span>@endif</td>
                <td>{{ $d['users'] }}</td>
                <td>@if(isset($d['answered']) && isset($d['contacted'])) {{ ($d['contacted']+$d['answered'] )}}  @elseif(isset($d['answered'])) {{ $d['answered'] }} @else 0 @endif</td>
                <td>@if(isset($d['employees']) && $d['employees']!=0) {{ $obj->getTime(round($d['avg_duration']/$d['employees'],2)) }} @else 0 @endif </td>
                <td>{{ $obj->getTime($d['total_duration']) }}</td>
                <td>{{ $d['admission'] }}</td>
                <td>{{ $d['score'] }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>

          
        </div>
        @endif
        <span class="text-primary">Performance Score = (Unique Customers * Avg Talktime in minutes) + (admissions * 100)</span><br>
          @if(request()->get('entity'))
          <span class="text-primary">Performance Days are calculated from monday to friday only </span>
          @endif
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