
<x-dynamic-component :component="$app->componentName" class="mt-4" >

	<!--begin::Breadcrumb-->
	<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
		<li class="breadcrumb-item">
			<a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="{{ route($app->module.'.index') }}"  class="text-muted">{{ ucfirst($app->module) }}</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">{{ $obj->name }}</a>
		</li>
	</ul>
	<!--end::Breadcrumb-->

	<!--begin::Alert-->
	@if($alert)
	  <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
	@endif
	<!--end::Alert-->

	<!--begin::Titlecard-->
	<x-snippets.cards.titlecard :title="$obj->name" :id="$obj->id" :module="$app->module" :obj="$obj" />
	<!--end::Titlecard-->


	<!--begin::basic card-->
	<x-snippets.cards.basic>
		<div class="row mb-2">
			<div class="col-md-4"><b>College Name</b></div>
			<div class="col-md-8">{{ $obj->name }}</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>College Code</b></div>
			<div class="col-md-8">{{ $obj->code }}</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Type</b></div>
			<div class="col-md-8">@if($obj->type=="engineering")
				<span class="badge badge-primary">Engineering</span>
				@elseif($obj->type=="degree")
				<span class="badge badge-success">Degree</span>
				@else
				<span class="badge badge-warning">Other</span>
			@endif</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Location</b></div>
			<div class="col-md-8">{{ $obj->location}}</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Zone</b></div>
			<div class="col-md-8">{{ $obj->zone}}</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>District</b></div>
			<div class="col-md-8">{{ $obj->district}}</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>State</b></div>
			<div class="col-md-8">{{ $obj->state}}</div>
		</div>
		<div class="card bg-light my-4">
			<div class="card-body">
				<div class="row mb-2">
					<div class="col-md-4"><b>Contact Person</b></div>
					<div class="col-md-8">{{ $obj->contact_person}}</div>
				</div>
				<div class="row mb-2">
					<div class="col-md-4"><b>Contact Designation</b></div>
					<div class="col-md-8">{{ $obj->contact_designation}}</div>
				</div>
				<div class="row mb-2">
					<div class="col-md-4"><b>Contact Phone</b></div>
					<div class="col-md-8">{{ $obj->contact_phone}}</div>
				</div>
				<div class="row mb-2">
					<div class="col-md-4"><b>Contact Email</b></div>
					<div class="col-md-8">{{ $obj->contact_email}}</div>
				</div>
				
			</div>
		</div>
		
		<div class="row mb-2">
			<div class="col-md-4"><b>Status</b></div>
			<div class="col-md-8">@if($obj->status==0)
				<span class="badge badge-warning">Inactive</span>
				@elseif($obj->status==1)
				<span class="badge badge-success">Active</span>
			@endif</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Created At</b></div>
			<div class="col-md-8">{{ ($obj->created_at) ? $obj->created_at->diffForHumans() : '' }}</div>
		</div>
	</x-snippets.cards.basic>
	<!--end::basic card-->   

	<div class="card border my-4 p-4">
			<h3>AccessCodes ({{$obj->name}}) </h3>
			<div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                  <tr>
                    <th scope="col"> Branches({{count(branches())}})</th>
                    <th scope="col">Registered ({{$students['count']}})</th>
                  </tr>
                </thead>
                <tbody>
					@foreach(branches() as $a=>$b)
					<tr @if(isset($students['branches'][$b])) style="background: #fff387;" @endif>
						@if(strlen($a)==1)
							<td><div @if($a%2==0)class="text-primary"@endif>{{$obj->id.'230'.$a}} - {{$b}}</div></td>
						@else

							<td><div @if($a%2==0)class="text-primary"@endif>{{$obj->id.'23'.$a}} - {{$b}}</div></td>
						@endif

						@if(isset($students['branches'][$b]))
						<td>{{ count($students['branches'][$b])}}</td>
						@else
						<td>0</td>
						@endif
					</tr>
					@endforeach
					</tbody>
				</table>
			</div>
			
			<span class="text-muted">(CollegeCode.YOP.BranchCode)</span>
		</div>

</x-dynamic-component>