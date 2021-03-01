
<x-dynamic-component :component="$app->componentName" class="mt-4" >

	<!--begin::Breadcrumb-->
	<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
      <li class="breadcrumb-item">
        <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('Theme.index') }}"  class="text-muted">Themes</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('Theme.show',$app->id) }}"  class="text-muted">Current Theme</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('Page.index',$app->id) }}"  class="text-muted">Pages</a>
      </li>
      <li class="breadcrumb-item">
        <a href="" class="text-muted">{{ $obj->slug}}</a>
      </li>
    </ul>
	<!--end::Breadcrumb-->

	<!--begin::Alert-->
	@if($alert)
	  <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
	@endif
	<!--end::Alert-->

	<!--begin::Titlecard-->
	<x-snippets.cards.titlecard :title="$obj->name" :id="$obj->id" :module="$app->module" :obj="$obj" :appid="$app->id" :preview="route('Page.theme',[$app->id,$obj->id])"/>
	<!--end::Titlecard-->


	<!--begin::basic card-->
	<x-snippets.cards.basic>
	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item" role="presentation">
			<button class="nav-link active" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="developer" aria-selected="true">Settings</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="developer-tab" data-bs-toggle="tab" data-bs-target="#developer" type="button" role="tab" aria-controls="developer" aria-selected="false">Developer Mode</button>
		</li>

	</ul>
	<div class="tab-content mt-5" id="myTabContent">
		<div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">

		@if(!$settings)
			No Settings defined
		@else
			<form method="post" action="{{route('Page.save',[$app->id,$obj->id])}}" enctype="multipart/form-data">
			@foreach($settings as $key=>$value)

			<div class="row mb-2">
					<div class="col-6 col-md-4"><b>{{ucfirst($key)}}</b></div>
					<div class="col-6 col-md-8">
						<input type="text" class="form-control" name="settings_{{$key}}" id="" value = "{{ $value }}">
					</div>
				</div>

			@endforeach
	        <input type="hidden" name="id" value="{{ $obj->id }}">
	        <input type="hidden" name="_token" value="{{ csrf_token() }}">
	        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
	        <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
	        <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
	        <input type="hidden" name="theme_id" value="{{ $app->id }}">
	        <button class="btn btn-primary" type="submit">Save Settings</button>
			</form>
		@endif
		
		</div>
		<div class="tab-pane fade" id="developer" role="tabpanel" aria-labelledby="developer-tab">
				<div class="row mb-2">
					<div class="col-md-4"><b>Name</b></div>
					<div class="col-md-8">{{ $obj->name }}</div>
				</div>
				<div class="row mb-2">
					<div class="col-md-4"><b>Slug</b></div>
					<div class="col-md-8">{{ $obj->slug }} <a href="{{ route('Page.theme',[$app->id,$obj->id]) }}" target="_blank" class="pl-3"><i class="flaticon-paper-plane text-primary"></i> view page</a></div>
				</div>

				
				<div class="row mb-2">
					<div class="col-md-4"><b>Client</b></div>
					<div class="col-md-8">{{ $obj->client->name }} ({{ $obj->client->domain }})</div>
				</div>
				<div class="row mb-2">
					<div class="col-md-4"><b>Html </b></div>
					<div class="col-md-8">
						<div class="" style="max-height: 400px;overflow: scroll;">
						<pre><code style="white-space: pre-wrap">{{ $obj->html}}</code></pre>
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-md-4"><b>Html minified</b></div>
					<div class="col-md-8">
						<div class="" style="max-height: 400px;overflow: scroll;">
						<pre><code style="white-space: pre-wrap">{{ $obj->html_minified}}</code></pre>
					</div>
					</div>
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
		</div>
	</div>
		
	</x-snippets.cards.basic>
	<!--end::basic card-->   

</x-dynamic-component>