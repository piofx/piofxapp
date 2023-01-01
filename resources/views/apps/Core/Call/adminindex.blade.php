
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
   

    <div class="col-12 ">
     
        @if(!request()->get('entity'))
        Filters: 
        <a href="{{ route('Call.adminindex')}}?filter=today"><span class="badge badge-success">Today</span></a> 
          <a href="{{ route('Call.adminindex')}}?filter=yesterday"><span class="badge badge-success">Yesterday</span></a> 
          <a href="{{ route('Call.adminindex')}}?filter=thismonth"><span class="badge badge-success">This Month</span></a> 
          <a href="{{ route('Call.adminindex')}}?filter=lastmonth"><span class="badge badge-success">Last Month</span></a> 
          <a href="{{ route('Call.adminindex')}}?filter=thisyear"><span class="badge badge-success">This Year</span></a> 
          <a href="{{ route('Call.adminindex')}}?filter=lastyear"><span class="badge badge-success">Last Year</span></a> 
          <a href="{{ route('Call.adminindex')}}?filter=last7days"><span class="badge badge-success">Last 7 days</span></a> 
          <a href="{{ route('Call.adminindex')}}?filter=last30days"><span class="badge badge-success">Last 30 days</span></a> 
          <a href="{{ route('Call.adminindex')}}?filter=overall"><span class="badge badge-success">Over All</span></a>

        <form>
        
        <div class="row mt-4">
          <div class="col-6 col-md-5">
            <input id="datetimepicker" type="text" class="form-control mb-3" name="start" placeholder="choose start date" value="{{ request()->get('start')}}">
          </div>
          <div class="col-6 col-md-6">
               <input id="datetimepicker2" type="text" class="form-control mb-3" name="end" placeholder="choose end date" value="{{ request()->get('end')}}">
          </div>
          <div class="col-6 col-md-1">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </form>
  
        @endif



        <!--begin::Advance Table Widget 3-->
        <div class="card card-custom gutter-b p-5 mt-4">

        <!--begin::Alert-->
        @if($alert)
          <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
        @endif
        <!--end::Alert-->

        <h3>
            @if(!request()->get('entity'))
              All Callers 
              <span class="badge badge-primary {{date_default_timezone_set("Asia/Kolkata")}}">
              @if(request()->get('filter')) {{request()->get('filter') }} 
              @elseif(request()->get('start'))
              Custom Date
              @else Today  
              @endif
              </span>
              <span class="badge badge-info">
              @if(request()->get('start'))
              {{ \carbon\carbon::parse(request()->get('start'))->format('d M Y')}} to 
              {{ \carbon\carbon::parse(request()->get('end'))->format('d M Y')}} 
             @endif
           </span>

              <small class="float-right d-none d-md-block"><span class="text-primary">Now:</span> {{date("l jS \of F Y h:i:s A")}}</small>
            @else
              @if(isset($data['entity_center']))
                Branch Performance
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
                <th scope="col">Walkin</th>
                <th scope="col">Demo</th>
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
                <td>{{ count($d['walkin']) }}</td>
                <td>{{ count($d['demo'])  }}</td>
                <td><a href="{{ route('Call.adminindex')}}?admitted={{$user}} @if(request()->get('filter'))&filter={{request()->get('filter')}} @endif">{{ count($d['admit']) }}</a></td>
                <td>{{ $d['score'] }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        
        @if(count($data['center'] ))
        <h3 class="mt-4">Branches</h3>

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
                <th scope="col">Walkin</th>
                <th scope="col">Demo</th>
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
                 <td>{{ $d['walkin'] }}</td>
                  <td>{{ $d['demo'] }}</td>
                <td><a href="{{ route('Call.adminindex')}}?admitted={{$user}} @if(request()->get('filter'))&filter={{request()->get('filter')}} @endif">{{ $d['admit'] }}</a></td>
                <td>{{ $d['score'] }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>

          </div>

          <span class="text-primary">Performance Score = (Unique Customers * Avg Talktime in minutes) + (walkin * 10) + (demo * 20) + (admission * 70)</span><br>
          @if(request()->get('entity'))
          <span class="text-primary">Performance Days are calculated from monday to friday only </span>
          @endif

          <h3 class="mt-5">Overall</h3>
          <div class="row mb-4">
            <div class="col-6 col-md-2">
              <div class="border rounded p-4 mb-3">
                <h5>Unique Users</h5>
                <div class="h2 text-primary">{{ $data['overall']['users']}}</div>
              </div>
            </div>
            <div class="col-6 col-md-2">
              <div class="border rounded p-4 mb-3">
                <h5>Total Calls</h5>
                <div class="h2 text-danger">{{ $data['overall']['interacted']}}</div>
              </div>
            </div>
            <div class="col-6 col-md-2">
              <div class="border rounded p-4">
                <h5>Talktime</h5>
                <div class="h3 text-success">{{ $data['overall']['talktime']}}</div>
              </div>
            </div>
             <div class="col-6 col-md-2">
              <div class="border rounded p-4">
                <h5>Walkin</h5>
                <div class="h2 text-warning">{{ $data['overall']['walkin']}}</div>
              </div>
            </div>
             <div class="col-6 col-md-2">
              <div class="border rounded p-4">
                <h5>Demo</h5>
                <div class="h2 text-warning">{{ $data['overall']['demo']}}</div>
              </div>
            </div>
            <div class="col-6 col-md-2">
              <div class="border rounded p-4">
                <h5>Admissions</h5>
                <div class="h2 text-warning">{{ $data['overall']['admission']}}</div>
              </div>
            </div>

          </div>

          
        
        @endif
        
          
                
        </div>
        <!--end::Advance Table Widget 3-->

    </div>
  </div>


</x-dynamic-component>

