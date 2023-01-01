<x-dynamic-component :component="$app->componentName" class="mt-4" >

  

  <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->

<div class="row">
  <div class="col-12 col-md-12">

    <div class="bg-white p-5">

       <h2 class="card-title mb-2"><i class="flaticon2-bell-4 text-success"></i> Admission List - {{ request()->get('admitted')}}</h2>
    <a href="{{ route('Call.adminindex')}}" class="mb-4">back to caller dashboard</a>

              <small class="float-right d-none d-md-block">{{date("l jS \of F Y h:i:s A")}}</small>

      <div class="table-responsive mb-5 mt-4">
          <table class="table table-bordered mb-5">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Cadidate Name</th>
                <th scope="col">Cadidate Phone</th>
                <th scope="col">Admission Date</th>
                <th scope="col">Caller Name</th>
              </tr>
            </thead>
            <tbody class="{{$k=1}}">
              @foreach($data['all'] as $user=>$d) 
              @if($user==request()->get('admitted'))
              @foreach($d['admit'] as $e)
              <tr>
                <td>{{$k++}}</td>
                <td>{{$e->name}}</td>
                <td>{{$e->phone}}</td>
                <td>{{$e->admission_date}}</td>
                <td>{{$user}}</td>
              </tr>
              @endforeach
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
      @foreach($data['all'] as $user=>$d) 
    
        @if($user==request()->get('admitted'))
        <ol>
          @foreach($d['admit'] as $e)
            <li>{{$e->name}} - {{$e->phone}} - {{$e->admission_date}} - [<span class="text-primary">{{$user}}</span>]</li> 
          @endforeach
        @endif
      </ol>
      @endforeach

      @foreach($data['center'] as $user=>$d) 
    
        @if($user==request()->get('admitted'))
        <ol>
          @foreach($d['admitted'] as $e)
            <li>{{$e['name']}} - [<span class="text-primary">{{$e['caller']}}</span>]</li> 
          @endforeach
        @endif
      </ol>
      @endforeach
        
    </div>
       
        
       
        
    </div>
  </div>
  
       


</x-dynamic-component>