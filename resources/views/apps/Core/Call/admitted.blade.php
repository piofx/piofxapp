<x-dynamic-component :component="$app->componentName" class="mt-4" >

  

  <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->

<div class="row">
  <div class="col-12 col-md-12">
  <!--begin::Indexcard-->
  <div class="card mb-4">
  <div class="card-body bg-light">
    
    <h2 class="card-title mb-2"><i class="flaticon2-bell-4 text-success"></i> Admission List - {{ request()->get('admitted')}}</h2>
    <a href="{{ route('Call.index')}}" class="mb-4">back to dashboard</a>

              <small class="float-right d-none d-md-block">{{date("l jS \of F Y h:i:s A")}}</small>
  </div>
</div>
  <!--end::Indexcard-->
      @foreach($data['all'] as $user=>$d) 
    
        @if($user==request()->get('admitted'))
        <ol>
          @foreach($d['admitted'] as $e)
            <li>{{$e}} - [<span class="text-primary">{{$user}}</span>]</li> 
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
  
       


</x-dynamic-component>