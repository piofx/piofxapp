<x-dynamic-component :component="$app->componentName" class="mt-4" >

	<div class="container mt-4">
		<h1> All Referrals ({{count($referrals)}})</h1>
		<hr>
		<div class="table-responsive">
			<table class="table table-bordered">
			  <thead>
			    <tr>
			      <th scope="col">Sno</th>
			      <th scope="col">Name</th>
			      <th scope="col">Count</th>
			      <th scope="col">Created</th>
			    </tr>
			  </thead>

			  <tbody data="{{$m=1}}">
			  	@foreach($referrals as $k=>$r)
			  	
			    <tr>
			      <th scope="row">{{($m++)}}</th>
			      <td ><span class="text-dark">{{$r[0]->referral_name}} [{{$r[0]->referral_id}}]</span><br></td>
			      <td >{{count($r)}} </td>
			      <td>{{ ($r[0]->created_at) ? $r[0]->created_at->diffForHumans() : '' }}</td>
			    </tr>
			    @endforeach
			    
			  </tbody>
			</table>
		</div>
	</div>
	 
</x-dynamic-component>