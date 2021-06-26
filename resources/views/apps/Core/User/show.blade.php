
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

	<div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                <div class="d-flex align-items-center">
                    <a href="#" class="h2 text-dark text-hover-primary mb-0">
					{{ $obj->name}}
                    </a> 
                </div>
                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                    <!--begin::Form-->
					<a href="{{ route($app->module.'.resetpassword',$obj->id)}}" class="text-muted"><button class="btn btn-info mt-4"><i class="flaticon-rotate"></i> Reset Password</button></a>
					<a href="{{ route($app->module.'.edit',$obj->id)}}" class="text-muted"><button class="btn btn-warning mt-4"><i class="flaticon-edit"></i> Edit</button></a>
					<a href="#" data-toggle="modal" class="text-muted" data-target="#staticBackdrop-{{$obj->id}}"><button class="btn btn-danger mt-4"><i class="flaticon-delete"></i> Delete</button></a>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
    <!--end::Indexcard-->

	<!--begin::basic card-->
	<x-snippets.cards.basic>
		<div class="row mb-2">
			<div class="col-md-4"><b>Name</b></div>
			<div class="col-md-8">{{ $obj->name }}</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Phone</b></div>
			<div class="col-md-8">{{ $obj->phone }} </div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Email</b></div>
			<div class="col-md-8">{{ $obj->email }} </div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Client</b></div>
			<div class="col-md-8">{{ $obj->client->name }} ({{ $obj->client->domain }})</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Role</b></div>
			<div class="col-md-8">
				<pre><code style="white-space: pre-wrap">{{ $obj->role}}</code></pre>
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
			<div class="col-md-4">{{ ($obj->created_at) ? $obj->created_at->diffForHumans() : '' }}</div>
		</div>
			
	</x-snippets.cards.basic>
	<!--end::basic card-->   

</x-dynamic-component>