
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

<div class='row'>
  <div class="col-12 col-md-2">
    @include('apps.Page.snippets.menu')
  </div>
  <div class="col-12 col-md-10">
  	<!--begin::Titlecard-->
	<x-snippets.cards.titlecard :title="$obj->name" :id="$obj->id" :module="$app->module" :obj="$obj" :appid="$app->id" :preview="route('Page.theme',[$app->id,$obj->id])"/>
	<!--end::Titlecard-->

		<!--begin::List Widget 1-->
				<div class="card card-custom gutter-b">
				  <!--begin::Header-->
				  <div class="card-header border-0 pt-5">
				    <h3 class="card-title ">
				    	<span>
				    		<span class="svg-icon svg-icon-secondary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Code/Terminal.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
        <rect fill="#000000" opacity="0.3" x="12" y="17" width="10" height="2" rx="1"/>
    </g>
</svg><!--end::Svg Icon--></span>
				    	</span>
				      <span class="card-label font-weight-bolder text-dark">Page Data</span>
				    </h3>
				  </div>
				  <!--end::Header-->
				  <!--begin::Body-->
				  <div class="card-body pt-8">
				  	@if(!$settings)
						 - Data not defined yet -
					@else
					
						<form method="post" action="{{route($app->module.'.show',[$app->id,$obj->id])}}" enctype="multipart/form-data">
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
				        <button class="btn btn-outline-primary mt-4" type="submit">Save Changes</button>
						</form>
					@endif
				  </div>
				</div>

		<!--begin::basic card-->
	<x-snippets.cards.basic>
	<h3 class="card-title ">
				    	<span>
				    		<span class="svg-icon svg-icon-light svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Text/Toggle-Left.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M2 11.5C2 12.3284 2.67157 13 3.5 13H20.5C21.3284 13 22 12.3284 22 11.5V11.5C22 10.6716 21.3284 10 20.5 10H3.5C2.67157 10 2 10.6716 2 11.5V11.5Z" fill="black"/>
  <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M9.5 20C8.67157 20 8 19.3284 8 18.5C8 17.6716 8.67157 17 9.5 17H20.5C21.3284 17 22 17.6716 22 18.5C22 19.3284 21.3284 20 20.5 20H9.5ZM15.5 6C14.6716 6 14 5.32843 14 4.5C14 3.67157 14.6716 3 15.5 3H20.5C21.3284 3 22 3.67157 22 4.5C22 5.32843 21.3284 6 20.5 6H15.5Z" fill="black"/>
    </g>
</svg><!--end::Svg Icon--></span>
				    	</span>
				      <span class="card-label font-weight-bolder text-dark">More details</span>
				    </h3>
				<div class="row mb-2">
					<div class="col-md-4"><b>Page Name</b></div>
					<div class="col-md-8">{{ $obj->name }}</div>
				</div>
				<div class="row mb-2">
					<div class="col-md-4"><b>Page Slug</b></div>
					<div class="col-md-8">{{ $obj->slug }} <a href="{{ route('Page.theme',[$app->id,$obj->id]) }}" target="_blank" class="pl-3"><i class="flaticon-paper-plane text-primary"></i> view page</a></div>
				</div>

				
				<div class="row mb-2">
					<div class="col-md-4"><b>Html </b></div>
					<div class="col-md-8">
						<div class="" style="max-height: 400px;overflow: scroll;border:1px solid #eee">
						<pre><code style="white-space: pre-wrap;">{{ $obj->html}}</code></pre>
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-md-4"><b>Html minified</b></div>
					<div class="col-md-8">
						<div class="" style="max-height: 400px;overflow: scroll;border:1px solid #eee">
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
		
		
	</x-snippets.cards.basic>
	<!--end::basic card-->   
  </div>
</div>
	




</x-dynamic-component>