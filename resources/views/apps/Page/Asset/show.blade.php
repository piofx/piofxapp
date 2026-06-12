
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
        <a href="{{ route('Asset.index',$app->id) }}"  class="text-muted">Assets</a>
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

<div class='row'>
  <div class="col-12 col-md-2">
    @include('apps.Page.snippets.menu')
  </div>
  <div class="col-12 col-md-10">
	<!--begin::Titlecard-->
	<x-snippets.cards.titlecard :title="$obj->name" :id="$obj->id" :module="$app->module" :obj="$obj" :appid="$app->id" />
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
			<div class="col-md-4"><b>Client</b></div>
			<div class="col-md-8">{{ $obj->client->name }} ({{ $obj->client->domain }})</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Path</b></div>
			<div class="col-md-8">
				{{ Storage::disk('s3')->url($obj->path)}} <a href="{{ Storage::disk('s3')->url($obj->path) }}" target="_blank" class="btn btn-sm btn-dark float-right"><i class="flaticon-db text-primary"></i> view asset</a>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-4"><b>Type</b></div>
			<div class="col-md-8">
				<pre><code style="white-space: pre-wrap">{{ $obj->type}}</code></pre>
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
</div>
</div>
</x-dynamic-component>