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
	<!--begin::Indexcard-->
    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-success">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                <div class="d-flex align-items-center">
                    <a href="#" class="h2 text-dark text-hover-primary mb-0">
					{{ ucfirst($app->module) }}
                    </a> 
                </div>
                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                    <!--begin::Form-->
					<a href="{{ route($app->module.'.resendmails',$obj->id)}}" class="text-muted"><button class="btn btn-info mt-4"><i class="flaticon-mail"></i> Resend Mails</button></a>
					<a href="{{ route($app->module.'.edit',$obj->id)}}" class="text-muted"><button class="btn btn-warning mt-4"><i class="flaticon-edit"></i> Edit</button></a>
					<a href="#" data-toggle="modal" class="text-muted" data-target="#staticBackdrop-{{$obj->id}}"><button class="btn btn-danger mt-4"><i class="flaticon-delete"></i> Delete</button></a>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
    <!--end::Indexcard-->
	         <!-- Confirm Delete Modal -->
					<div class="modal fade" id="staticBackdrop-{{$obj->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Confirm Delete</h5>
                            <button type="button" class="btn btn-xs btn-icon btn-soft-secondary" data-dismiss="modal" aria-label="Close">
                            <svg aria-hidden="true" width="10" height="10" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                            </svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            Do you want to delete this permanently?
                        </div>
                        <div class="modal-footer">
						<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
							<form action="{{ route($app->module.'.destroy', $obj->id) }}" method="POST">
								@csrf
								<input type="hidden" name="_method" value="DELETE">
								<button type="submit" class="btn btn-danger">Confirm Delete</button>
							</form>
							</div>
                        </div>
                    </div>
                </div>
                <!-- End Confirm Delete Modal -->

	<!--begin::basic card-->
	<x-snippets.cards.basic>
		<div class="row mb-2">
			<div class="col-md-4"><b>Name</b></div>
			<div class="col-md-8">{{ $obj->name }}</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Description</b></div>
			<div class="col-md-8">{{ $obj->description }} </div>
		</div>
        <div class="row mb-2">
			<div class="col-md-4"><b>Emails</b></div>
			<div class="col-md-8">{{ $obj->emails }} </div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Scheduled_At</b></div>
			<div class="col-md-8">{{ $obj->scheduled_at }} </div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Template</b></div>
			<div class="col-md-8">{{ $template->name }} </div>
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