<x-dynamic-component :component="$app->componentName" class="mt-4" >
	<div class="page_wrapper">
		<div class="page_container">
			
			 <x-snippets.cards.basic>
    @if($objs->total()!=0)
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
                 <br> 
                 {{ $obj->branch }}
                 <br> 
                 {{ $obj->yop }}
                 <br> 
                  {{$obj->phone}}<br>
                    {{ $obj->email }} 
                     
                        <br>
                      @if($obj->status==0)
                  <span class="label label-light-success label-pill label-inline">Customer</span>
                  @elseif($obj->status==1)
                  <span class="label label-light-warning label-pill label-inline">Open Lead</span>
                  @elseif($obj->status==2)
                  <span class="label label-light-danger label-pill label-inline">Cold Lead</span>
                  @elseif($obj->status==3)
                  <span class="label label-light-info label-pill label-inline">Warm Lead</span>
                  @elseif($obj->status==4)
                  <span class="label label-light-primary label-pill label-inline">Prospect</span>
                  @elseif($obj->status==5)
                  <span class="label label-light-light label-pill text-dark label-inline">Not Responded</span>
                  @endif
                 
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
        @else
        <div class="card card-body bg-light">
          No items found
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($objs->total() > config('global.no_of_records'))mt-3 @endif">
        {{$objs->appends(['status'=>request()->get('status'),'user_id'=>request()->get('user_id'),'tag'=>request()->get('tag'),'category'=>request()->get('category'),'date_filter'=>request()->get('date_filter')])->links()  }}
      </nav>
  </x-snippets.cards.basic>
  <!--end::basic card-->

		</div>
	</div>
</x-dynamic-component>