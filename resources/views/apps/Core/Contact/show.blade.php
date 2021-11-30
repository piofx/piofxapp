
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


	<div class="row">
		<div class="col-12 col-md">
			<!--begin::basic card-->
				<x-snippets.cards.basic>
					<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Name</b></div>
						<div class="col-8 col-md-8">{{ $obj->name }}</div>
					</div>
					<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Email</b></div>
						<div class="col-8 col-md-8">{{ $obj->email }} @if($obj->valid_email)
			                        <i class="far fa-check-circle text-success"></i> 
			                      @elseif($obj->valid_email===0)
			                        <i class="far fa-times-circle text-danger"></i> 
			                      @endif</div>
					</div>
					<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Phone</b></div>
						<div class="col-8 col-md-8">{{ $obj->phone }} </div>
					</div>
					<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Category</b></div>
						<div class="col-8 col-md-8"><span class="label label-light-dark label-pill label-inline">{{ $obj->category }}</span> </div>
					</div>
					<div class="row mb-2">
						<div class="col-md-4"><b class="">Message</b> <span class="text-muted ml-2"> {{ ($obj->created_at) ? $obj->created_at->diffForHumans() : '' }}</span></div>
						<div class="col-md-8">
							<pre class="mt-2 mt-md-0 bg-light rounded p-4">{!! $obj->message !!}</pre>
						</div>
					</div>
					@if($obj->comment)
					<div class="row mb-2">
						<div class="col-md-4"><b>Comment</b> <span class="text-muted ml-2"> {{ ($obj->updated_at) ? $obj->updated_at->diffForHumans() : '' }}</span></div>
						<div class="col-md-8">
							<pre class="mt-2 mt-md-0 bg-light rounded p-4">{!! $obj->comment !!}</pre>
						</div>
					</div>
					@endif

					@if($obj->tags)
					<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Tags</b></div>
						<div class="col-8 col-md-8">
							@foreach(explode(',',$obj->tags) as $tag)
							<span class="badge badge-success">{{ $tag }}</span>
							@endforeach
						</div>
					</div>
					@endif

					@if($obj->user)
					<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Replied By</b></div>
						<div class="col-8 col-md-8"><span class="badge badge-info">{{ $obj->user->name }}</span></div>
					</div>
					@endif
					<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Created</b></div>
						<div class="col-8 col-md-8">{{ $obj->created_at->format('d M Y') }}</div>
					</div>
					<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Status</b></div>
						<div class="col-8 col-md-8">
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
						</div>
					</div>
				</x-snippets.cards.basic>
				<!--end::basic card-->   
		</div>
		@if($user)
		<div class="col-12 col-md-3">
			<!--begin::basic card-->
			<x-snippets.cards.basic class="bg-primary text-white">
				<h4><i class="fa fa-user text-white"></i> Registered Info</h4>
				<hr>
				<div class="row mb-2">
						<div class="col-4 col-md-4"><b>UID</b></div>
						<div class="col-8 col-md-8">{{ $user->id }}</div>
				</div>
				<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Name</b></div>
						<div class="col-8 col-md-8">{{ $user->name }}</div>
				</div>
				<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Email</b></div>
						<div class="col-8 col-md-8">{{ $user->email }}</div>
				</div>
				<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Phone</b></div>
						<div class="col-8 col-md-8">{{ $user->phone }}</div>
				</div>
				<hr>
				<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Data</b></div>
						<div class="col-8 col-md-8">{!! $user->data !!}</div>
				</div>
				<div class="row mb-2">
						<div class="col-4 col-md-4"><b>Last Login</b></div>
						<div class="col-8 col-md-8"><span class="badge badge-success">{!! $user->updated_at->diffForHumans() !!}</span></div>
				</div>
			</x-snippets.cards.basic>
			<!--end::basic card-->  
		</div>
		@endif
	</div>
	


	@if(count($objs))
	<h1 class="p-2 mt-4">Previous Interactions</h1>
	@foreach($objs as $obj)
	<!--begin::basic card-->
	<x-snippets.cards.basic class="border mt-4">
		<div class="row mb-2">
			<div class="col-md-4"><b class="">Message</b> <span class="text-muted ml-2"> {{ ($obj->created_at) ? $obj->created_at->diffForHumans() : '' }}</span></div>
			<div class="col-md-8">
				<pre class="mt-2 mt-md-0 bg-light rounded p-4">{!! $obj->message !!}</pre>
			</div>
		</div>
		@if($obj->comment)
		<div class="row mb-2">
			<div class="col-md-4"><b>Comment</b> <span class="text-muted ml-2"> {{ ($obj->updated_at) ? $obj->updated_at->diffForHumans() : '' }}</span></div>
			<div class="col-md-8">
				<pre class="mt-2 mt-md-0 bg-light rounded p-4">{!! $obj->comment !!}</pre>
			</div>
		</div>
		@endif
		@if($obj->user)
		<div class="row mb-2">
			<div class="col-4 col-md-4"><b>Replied By</b></div>
			<div class="col-8 col-md-8"><span class="badge badge-info">{{ $obj->user->name }}</span></div>
		</div>
		@endif
		<div class="row mb-2">
			<div class="col-4 col-md-4"><b>Created</b></div>
			<div class="col-8 col-md-8">{{ $obj->created_at->format('d M Y') }}</div>
		</div>
		<div class="row mb-2">
			<div class="col-4 col-md-4"><b>Status</b></div>
			<div class="col-8 col-md-8">
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
				@endif
			</div>
		</div>
	</x-snippets.cards.basic>
	<!--end::basic card--> 
	@endforeach
	@endif
</x-dynamic-component>