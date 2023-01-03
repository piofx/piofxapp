<x-dynamic-component :component="$app->componentName" class="mt-4" >

  

  <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->

<div class="row">
  <div class="col-12 col-md-12">

    <div class="border rounded p-3 mb-4">
      @if(!request()->get('entity'))
        
        <form>
        
        <div class="row mt-4">
          <div class="col-6 col-md-3">
            <b>Start Date</b><br>
            <input id="datetimepicker" type="text" class="form-control mb-3" name="start" placeholder="choose start date" value="{{ request()->get('start')}}">
          </div>
          <div class="col-6 col-md-3">
            <b>End Date</b><br>
               <input id="datetimepicker2" type="text" class="form-control mb-3" name="end" placeholder="choose end date" value="{{ request()->get('end')}}">
          </div>
          <div class="col-6 col-md-3">
            <b>Caller/Center</b><br>
            <select class="form-control form-select" 
                name="caller"
              >
              @foreach($data['all'] as $user=>$d) 
              <option value="{{$user}}" 
                    @if($user==request()->get('admitted'))
                      selected                    
                    @elseif($user==request()->get('demo'))
                      selected  
                    @elseif($user==request()->get('walkin'))
                      selected  
                    @endif
                  >{{$user}}</option>
              @endforeach
              @foreach($data['center'] as $user=>$d) 
              <option value="{{$user}}" 
                    @if($user==request()->get('admitted'))
                      selected                    
                    @elseif($user==request()->get('demo'))
                      selected  
                    @elseif($user==request()->get('walkin'))
                      selected  
                    @endif
                  >{{$user}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-6 col-md-2">
            <b>List</b><br>
            <select class="form-control form-select" name="list">
              <option value="admitted" 
                    @if(request()->get('admitted'))
                      selected  
                    @endif
                  >Admission</option>
              <option value="demo" 
                    @if(request()->get('demo'))
                      selected  
                    @endif
                  >Demo</option>
              <option value="walkin" 
                    @if(request()->get('walkin'))
                      selected  
                    @endif
                  >Walkin</option>
            </select>
          </div>
          <div class="col-6 col-md-1">
            <b> </b><br>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </form>
  
        @endif
    </div>
    <div class="bg-white p-5">
       <h2 class="card-title mb-2"><i class="flaticon2-bell-4 text-success"></i> 

        @if(request()->get('admitted'))
          Admission  List - {{ request()->get('admitted')}}
        @elseif(request()->get('demo'))
          Demo List - {{ request()->get('demo')}}
        @elseif(request()->get('walkin'))
          Walkin  List - {{ request()->get('walkin')}} 
            @if(request()->get('walkin')==strtoupper(request()->get('walkin')))
              <a href="{{ route('Call.adminindex')}}?walkin={{request()->get('walkin')}}&start={{request()->get('start')}}&end={{request()->get('end')}}&download=1" class="btn btn-primary btn-sm">Download</a>
            @endif
        @endif

       </h2>
    <a href="{{ route('Call.adminindex')}}" class="mb-4">back to caller dashboard</a>

    <small class="float-right d-none d-md-block"><span class="text-primary">Now:</span> {{date("l jS \of F Y h:i:s A")}}</small>

      <div class="table-responsive mb-3 mt-4">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">Sno</th>
                <th scope="col">Cadidate <br>Name</th>
                <th scope="col">Cadidate <br>Phone</th>
                <th scope="col">
                    @if(request()->get('admitted'))
                      Admission 
                    @elseif(request()->get('demo'))
                      Demo
                    @elseif(request()->get('walkin'))
                      Walkin
                    @endif
                    <br>Date
                </th>
                @if(request()->get('walkin'))
                <th scope="col">Demo</th>
                <th scope="col">Admission</th>
                @endif
                <th scope="col">Caller <br>Name</th>
                <th scope="col">YOP</th>
                <th scope="col">Branch</th>
                <th scope="col">Percent</th>
                <th scope="col">Backlogs</th>
                <th scope="col">Remarks</th>
              </tr>
            </thead>
            <tbody class="{{$k=1}}">
              @foreach($data['all'] as $user=>$d) 
                @if($user==request()->get('admitted'))
                  @foreach($d['admit'] as $e)
                  <tr data-value="">
                    <td>{{$k++}}</td>
                    <td>{{$e->name}}</td>
                    <td>{{$e->phone}}</td>
                    <td>{{$e->admission_date}}</td>
                    <td>{{$user}}</td>
                    @if(isset(json_decode($e->data)->year_of_passing))
                    <td>{{json_decode($e->data)->year_of_passing}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->branch))
                    <td>{{json_decode($e->data)->branch}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->graduation_percentage))
                    <td>{{json_decode($e->data)->graduation_percentage}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->backlogs))
                    <td>{{json_decode($e->data)->backlogs}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->remarks))
                    <td>{{json_decode($e->data)->remarks}}</td>
                    @else
                    <td>-</td>
                    @endif
                  </tr>
                  @endforeach
                @endif
                @if($user==request()->get('demo'))
                  @foreach($d['demo'] as $e)
                  <tr data-value="">
                    <td>{{$k++}}</td>
                    <td>{{$e->name}}</td>
                    <td>{{$e->phone}}</td>
                    <td>{{$e->demo_date}}</td>
                    <td>{{$user}}</td>
                    @if(isset(json_decode($e->data)->year_of_passing))
                    <td>{{json_decode($e->data)->year_of_passing}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->branch))
                    <td>{{json_decode($e->data)->branch}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->graduation_percentage))
                    <td>{{json_decode($e->data)->graduation_percentage}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->backlogs))
                    <td>{{json_decode($e->data)->backlogs}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->remarks))
                    <td>{{json_decode($e->data)->remarks}}</td>
                    @else
                    <td>-</td>
                    @endif
                  </tr>
                  @endforeach
                @endif
                @if($user==request()->get('walkin'))
                  @foreach($d['walkin'] as $e)
                  <tr data-value="">
                    <td>{{$k++}}</td>
                    <td>{{$e->name}}</td>
                    <td>{{$e->phone}}</td>
                    <td>{{$e->walkin_date}}</td>
                    <td>@if($e->demo_date) yes @endif</td>
                    <td>@if($e->admission_date) yes @endif</td>
                    <td>{{$user}}</td>
                    @if(isset(json_decode($e->data)->year_of_passing))
                    <td>{{json_decode($e->data)->year_of_passing}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->branch))
                    <td>{{json_decode($e->data)->branch}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->graduation_percentage))
                    <td>{{json_decode($e->data)->graduation_percentage}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->backlogs))
                    <td>{{json_decode($e->data)->backlogs}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->remarks))
                    <td>{{json_decode($e->data)->remarks}}</td>
                    @else
                    <td>-</td>
                    @endif
                  </tr>
                  @endforeach
                @endif
              @endforeach

              @foreach($data['center'] as $user=>$d) 
                @if($user==request()->get('admitted'))
                  @foreach($d['admit_list'] as $e)
                  <tr data-value="">
                    <td>{{$k++}}</td>
                    <td>{{$e->name}}</td>
                    <td>{{$e->phone}}</td>
                    <td>{{$e->admission_date}}</td>
                    <td>{{$e->caller_name}}</td>
                    @if(isset(json_decode($e->data)->year_of_passing))
                    <td>{{json_decode($e->data)->year_of_passing}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->branch))
                    <td>{{json_decode($e->data)->branch}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->graduation_percentage))
                    <td>{{json_decode($e->data)->graduation_percentage}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->backlogs))
                    <td>{{json_decode($e->data)->backlogs}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->remarks))
                    <td>{{json_decode($e->data)->remarks}}</td>
                    @else
                    <td>-</td>
                    @endif
                  </tr>
                  @endforeach
                @endif
                @if($user==request()->get('demo'))
                  @foreach($d['demo_list'] as $e)
                  <tr data-value="">
                    <td>{{$k++}}</td>
                    <td>{{$e->name}}</td>
                    <td>{{$e->phone}}</td>
                    <td>{{$e->demo_date}}</td>
                    <td>{{$e->caller_name}}</td>
                    @if(isset(json_decode($e->data)->year_of_passing))
                    <td>{{json_decode($e->data)->year_of_passing}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->branch))
                    <td>{{json_decode($e->data)->branch}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->graduation_percentage))
                    <td>{{json_decode($e->data)->graduation_percentage}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->backlogs))
                    <td>{{json_decode($e->data)->backlogs}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->remarks))
                    <td>{{json_decode($e->data)->remarks}}</td>
                    @else
                    <td>-</td>
                    @endif
                  </tr>
                  @endforeach
                @endif
                @if($user==request()->get('walkin'))
                  @foreach($d['walkin_list'] as $e)
                  <tr data-value="">
                    <td>{{$k++}}</td>
                    <td>{{$e->name}}</td>
                    <td>{{$e->phone}}</td>
                    <td>{{$e->walkin_date}}</td>
                    <td>@if($e->demo_date) yes @else - @endif</td>
                    <td>@if($e->admission_date) yes @else - @endif</td>
                    <td>{{$e->caller_name}}</td>
                    @if(isset(json_decode($e->data)->year_of_passing))
                    <td>{{json_decode($e->data)->year_of_passing}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->branch))
                    <td>{{json_decode($e->data)->branch}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->graduation_percentage))
                    <td>{{json_decode($e->data)->graduation_percentage}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->backlogs))
                    <td>{{json_decode($e->data)->backlogs}}</td>
                    @else
                    <td>-</td>
                    @endif
                    @if(isset(json_decode($e->data)->remarks))
                    <td>{{json_decode($e->data)->remarks}}</td>
                    @else
                    <td>-</td>
                    @endif
                  </tr>
                  @endforeach
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
      
        
    </div>
       
        
       
        
    </div>
  </div>
  
       


</x-dynamic-component>