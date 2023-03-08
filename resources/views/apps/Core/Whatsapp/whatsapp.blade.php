<x-dynamic-component :component="$app->componentName" class="mt-4" >
	<div class="page_wrapper">
		<div class="page_container">
			
			 <x-snippets.cards.basic>
    @if($objs->total()!=0)
        <h3> Recent Registrtions</h3>
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr class="bg-light">
                <th scope="col">#({{$objs->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col" style="max-width: 200px ;">Zone</th>
                <th scope="col">Created</th>
              </tr>
            </thead>
            <tbody>
              @foreach($objs as $key=>$obj)  
              <tr>
                <th scope="row">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                	<h5>{{ $obj->name }}</h5>
                  {{ $obj->college }}
                
                 
                </td>
                  <td> 
                    <div class="">
                    	{{ $obj->zone }}
                    </div>
                    
                  </td>
                <td>{{ ($obj->created_at) ? $obj->created_at->diffForHumans() : '' }} </td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
         <nav aria-label="Page navigation  " class="card-nav @if($objs->total() > config('global.no_of_records'))mt-3 @endif">
        {{$objs->appends(['status'=>request()->get('status'),'user_id'=>request()->get('user_id'),'tag'=>request()->get('tag'),'category'=>request()->get('category'),'date_filter'=>request()->get('date_filter')])->links()  }}
      </nav>
      
    <div class="p-3" style="background-color: #feffd0;">
      <h3 class="mt-4"> Zones</h3>
      <div class="row">
        @foreach($zones as $zone=>$val)
        @if($zone)
        <div class="col-6 col-md-2 mb-3">
          <div class="border rounded p-4">
            <h5>{{$zone}}</h5>
            <div class="display-3">{{ count($val)}}</div>
          </div>
        </div>
        @endif
        @endforeach
      </div>
    </div>

    <h3 class="mt-4"> College Data</h3>
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr class="bg-light">
                <th scope="col">#({{$objs->total()}})</th>
                <th scope="col">College Name </th>
                <th scope="col">Counter</th>
              </tr>
            </thead>
            <tbody class="{{$i=1}}">
              @foreach($colleges as $key=>$obj)  
              <tr>
                <th scope="row">{{ $i++ }}</th>
                <td>
                  {{ $key }}
                
                 
                </td>
                  <td> 
                    <div class="">
                      {{ count($obj) }}
                    </div>
                    
                  </td>
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
       
  </x-snippets.cards.basic>
  <!--end::basic card-->

		</div>
	</div>
</x-dynamic-component>