
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
		
<div class='row'>
	<div class="col-12 col-md-10">
		

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
				<div class="col-md-4"><b>Name</b></div>
				<div class="col-md-8">{{ $obj->name }}</div>
			</div>
			<div class="row mb-2">
				<div class="col-md-4"><b>Preview Image</b></div>
				<div class="col-md-8">
					@if(Storage::disk('public')->exists('themes/'.$obj->id.'/file_'.$obj->id.'_preview.jpg'))
					<img src="{{ Storage::disk('local')->url('themes/'.$obj->id.'/file_'.$obj->id.'_preview.jpg')}}" style="width:18em;border:2px solid silver;border-radius:4px"/>
					@endif
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-md-4"><b>Slug</b></div>
				<div class="col-md-8">{{ $obj->slug }} </div>
			</div>
			<div class="row mb-2">
				<div class="col-md-4"><b>Client</b></div>
				<div class="col-md-8">{{ $obj->client->name }} ({{ $obj->client->domain }})</div>
			</div>

			<div class="row mb-2">
				<div class="col-md-4"><b>Settings</b></div>
				<div class="col-md-8">
					<pre><code style="white-space: pre-wrap">{{ $obj->settings}}</code></pre>
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

			<div class="row mb-2">
				<div class="col-md-4"><b>Download</b></div>
				<div class="col-md-8">
					<form method="post" action="{{route($app->module.'.download',$app->id)}}" enctype="multipart/form-data">
			            
			                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
			                  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

			                  <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
			                  <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
			            <input type="hidden" name="theme_id" value="{{ $app->id }}">
			            <button type="submit" class="btn btn-outline-success btn-sm  font-weight-bold">Download</button>
			        </form>
				</div>
			</div>

			
		</x-snippets.cards.basic>
		<!--end::basic card-->   
	</div>
	<div class="col-12 col-md-2">
		@include('apps.Page.snippets.menu')
	</div>
</div>
</x-dynamic-component>