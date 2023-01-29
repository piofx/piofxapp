
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
			<h3>AccessCodes (CollegeCode.YOP.BranchCode)</h3>
			@foreach(branches() as $a=>$b)
				@if(strlen($a)==1)
					<div>{{$obj->id.'230'.$a}} - {{$b}}</div>
				@else
					<div>{{$obj->id.'23'.$a}} - {{$b}}</div>
				@endif
			@endforeach
		</div>

</x-dynamic-component>