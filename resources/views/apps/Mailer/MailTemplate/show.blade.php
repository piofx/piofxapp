<x-dynamic-component :component="$app->componentName" class="mt-4" >

	<!--begin::Breadcrumb-->
	<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
		<li class="breadcrumb-item">
			<a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="{{ route($app->module.'.index') }}"  class="text-muted">{{ ucfirst($app->module) }}</a>
		</li>
	</ul>
	<!--end::Breadcrumb-->

	<!--begin::Alert-->
	@if($alert)
	  <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
	@endif
	<!--end::Alert-->

	<!--begin::Titlecard-->
	<x-snippets.cards.titlecard :title="$app->module" :id="$obj->id" :module="$app->module" :obj="$obj" />
	<!--end::Titlecard-->


	<!--begin::basic card-->
	<x-snippets.cards.basic>
		<div class="row mb-2">
			<div class="col-md-4"><b>Name</b></div>
			<div class="col-md-8">{{ $obj->name }}</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Slug</b></div>
			<div class="col-md-8">{{ $obj->slug }} </div>
		</div>
        <div class="row mb-2">
			<div class="col-md-4"><b>Subject</b></div>
			<div class="col-md-8">{{ $obj->subject }} </div>
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
			<div class="col-md-4">{{ ($obj->created_at) ? $obj->created_at->diffForHumans() : '' }}</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Html Template</b></div>
			<div class="col-md-8">{{ $obj->message }} </div>
		</div>
		
	</x-snippets.cards.basic>
	<!--end::basic card-->   

</x-dynamic-component>