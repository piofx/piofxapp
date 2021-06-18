
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

	<div class="row">
	    <div class="col-12 col-md-2">
	      
	     @include('apps.Page.snippets.menu')

	     
    	</div>

    	<div class="col-12 col-md-10">
    		<!--begin::Stats Widget 4-->
      <div class="card card-custom gutter-b bg-primary-o-50  " style="border:1px solid #bed2ea">
        <div class="row">
          <div class="col-12 col-md-2">
            @if(Storage::disk('s3')->exists('themes/'.$obj->id.'/file_preview.jpg'))
            <div class="pr-8">
            <img src="{{ Storage::disk('s3')->url('themes/'.$obj->id.'/file_preview.jpg')}}" class="w-100 m-8 border rounded"/>
            </div>
              @elseif(Storage::disk('s3')->exists('themes/'.$obj->id.'/file_preview.png'))
               <img src="{{ Storage::disk('s3')->url('themes/'.$obj->id.'/file_preview.png')}}" class="w-100 p-8"/>
               @else
                <img src="{{ asset('img/theme/themedefault.png')}}" class="w-100 p-8"/>
               @endif
            
            </div>
            <div class="col-12 col-md-10">
             <!--begin::Body-->
             <div class="pl-0 card-body  d-flex align-items-center py-0 mt-1 ">
              <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                
                <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-2 text-hover-primary">{{ ucfirst($obj->name)}}</a>
                	<span class="font-weight-bold  font-size-lg">/{{$obj->slug}}</span>
                  @if(request()->get('client.theme.active'))
                  <span class="text-white label label-inline label-success" style="max-width:50px">Active</span>
                  @else
                  <span class="text-warning">Inactive</span>
                  @endif
                </div>
                <div class="btn-group" role="group" aria-label="First group">
                  <a href="{{ route('Theme.page',$obj->id)}}"  class="btn btn-primary "><i class="la la-eye"></i> preview</a>
                  <a href="{{ route('Theme.edit',$obj->id)}}"  class="btn btn-success "><i class="la la-gear"></i> Settings</a>
                  	 <a href="{{ route('Theme.edit',$obj->id)}}"  class="btn btn-danger "><i class="la la-trash"></i> Delete</a>

                </div>
              </div>

              <!--end::Body-->
            </div>
          </div>
        </div>
        <!--end::Stats Widget 4-->

        <!--begin::Alert-->
		@if($alert)
		  <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
		@endif
		<!--end::Alert-->
        <div class="row">
        	<div class="col-12 col-md">
        		<!--begin::List Widget 1-->
				<div class="card card-custom gutter-b">
				  <!--begin::Header-->
				  <div class="card-header border-0 pt-5">
				    <h3 class="card-title ">
				    	<span>
				    		<span class="svg-icon svg-icon-secondary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Layout/Layout-4-blocks.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						        <rect x="0" y="0" width="24" height="24"/>
						        <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"/>
						        <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"/>
						    </g>
						</svg><!--end::Svg Icon--></span>
				    	</span>
				      <span class="card-label font-weight-bolder text-dark">Theme Global Data</span>
				    </h3>
				  </div>
				  <!--end::Header-->
				  <!--begin::Body-->
				  <div class="card-body pt-8">
				  	@if(!$settings)
						 - Data not defined yet -
					@else
					
						<form method="post" action="{{route($app->module.'.show',$app->id)}}" enctype="multipart/form-data">
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

					<div class="row">
        			<div class="col-12 col-md-6">
        				 <!--begin::upload element-->
					      <div class="card card-custom bgi-no-repeat  gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('/themes/metronic/media/svg/patterns/abstract-4.svg') }}">
					        <div class="card-body">
					          <a href="#" class="card-title font-weight-bold text-muted text-hover-primary font-size-h5">Update Theme </a>
					          <div class="font-weight-bold text-success mt-2 mb-5">Upload only zip files</div>
					          <form method="post" action="{{route('Theme.upload',$app->id)}}" enctype="multipart/form-data">
					            <input type="file" class="form-control-file" name="file" id="exampleFormControlFile1" multiple>
					            <input type="hidden" name="_token" value="{{ csrf_token() }}">
					            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
					            <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
					            <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
					            <input type="hidden" name="theme_id" value="{{ $obj->id }}">
					            	<input type="hidden" name="theme_slug" value="{{ $obj->slug}}">
					            <button type="submit" class="btn btn-warning mt-4"><i class="la la-cloud"></i> Update</button>
					          </form>
					        </div>
					      </div>
					      <!--end::upload element-->
        			</div>
        			<div class="col-12 col-md-6">
        				 <!--begin::upload element-->
					      <div class="card card-custom bgi-no-repeat  gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('/themes/metronic/media/svg/patterns/abstract-4.svg') }}">
					        <div class="card-body">
					          <a href="#" class="card-title font-weight-bold text-muted text-hover-primary font-size-h5">Download Theme </a>

					          <form method="post" action="{{route($app->module.'.devmode.zip',$app->id)}}?zip=1" enctype="multipart/form-data">
						            
						                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
						                  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

						                  <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
						                  <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
						            <input type="hidden" name="theme_id" value="{{ $obj->id }}">
						            <button type="submit" class="btn btn-primary  font-weight-bold mt-2">From Storage</button>
						        </form>
						        <form method="post" action="{{route($app->module.'.download',$app->id)}}" enctype="multipart/form-data">
						            <input type="hidden" name="_token" value="{{ csrf_token() }}">
						            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
												<input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
						            <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
						            <input type="hidden" name="theme_id" value="{{ $obj->id }}">
						            <button type="submit" class="btn btn-success  font-weight-bold mt-3">From Cloud</button>
						        </form>
					        </div>
					      </div>
					      <!--end::upload element-->

        			</div>
        		</div>
        	</div>
        	@env('local')
        	<div class="col-12 col-md-4">
        		<div class="card mb-0">
        			<div class="card-body ">
        				<h3 class="mb-3">Developer Tools </h3>
        				<p>Dev Mode: 
        					@if(request()->get('client.devmode'))
								<span class="label label-light-primary label-inline">True</span>
								@else
								<span class="label label-light-danger label-inline">False</span>
							@endif
        				</p>
        				<div class="row">
        					<div class="col-12 col-lg-6">
        		<!--begin::Tiles Widget 11-->
        		<div class="card card-custom bg-light-success border border-success gutter-b" style="">
        			<div class="card-body">
        				<span class="svg-icon svg-icon-success svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Download.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						        <rect x="0" y="0" width="24" height="24"/>
						        <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
						        <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="1" width="2" height="14" rx="1"/>
						        <path d="M7.70710678,15.7071068 C7.31658249,16.0976311 6.68341751,16.0976311 6.29289322,15.7071068 C5.90236893,15.3165825 5.90236893,14.6834175 6.29289322,14.2928932 L11.2928932,9.29289322 C11.6689749,8.91681153 12.2736364,8.90091039 12.6689647,9.25670585 L17.6689647,13.7567059 C18.0794748,14.1261649 18.1127532,14.7584547 17.7432941,15.1689647 C17.3738351,15.5794748 16.7415453,15.6127532 16.3310353,15.2432941 L12.0362375,11.3779761 L7.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000004, 12.499999) rotate(-180.000000) translate(-12.000004, -12.499999) "/>
						    </g>
						</svg><!--end::Svg Icon--></span>
        				<div class="text-success font-weight-bolder font-size-h2 mt-3 mb-4">Pull</div>
        				<form method="post" action="{{route($app->module.'.devmode',$app->id)}}?code=1&s3=1" enctype="multipart/form-data">
				            
				                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
				                  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

				                  <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
				                  <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
				            <input type="hidden" name="theme_id" value="{{ $app->id }}">
				            <button type="submit" class="btn btn-outline-success btn-sm  font-weight-bold">All Files</button>
				        </form>
				        <form method="post" action="{{route($app->module.'.devmode',$app->id)}}?code=1" enctype="multipart/form-data">
				            
				                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
				                  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

				                  <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
				                  <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
				            <input type="hidden" name="theme_id" value="{{ $app->id }}">
				            <button type="submit" class="btn btn-outline-success mt-3 btn-sm  font-weight-bold">Code</button>
				        </form>
				        <form method="post" action="{{route($app->module.'.devmode',$app->id)}}?s3=1" enctype="multipart/form-data">
				            
				                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
				                  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

				                  <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
				                  <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
				            <input type="hidden" name="theme_id" value="{{ $app->id }}">
				            <button type="submit" class="btn btn-outline-success mt-3 btn-sm  font-weight-bold">Assets</button>
				        </form>

        			</div>
        		</div>
        		<!--end::Tiles Widget 11-->

        	

        	</div>
        	<div class="col-12 col-lg-6">
        		<!--begin::Tiles Widget 11-->
        		<div class="card card-custom bg-light-info border border-info gutter-b" style="">
        			<div class="card-body">
        				<span class="svg-icon svg-icon-info svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Upload.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						        <rect x="0" y="0" width="24" height="24"/>
						        <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
						        <rect fill="#000000" opacity="0.3" x="11" y="2" width="2" height="14" rx="1"/>
						        <path d="M12.0362375,3.37797611 L7.70710678,7.70710678 C7.31658249,8.09763107 6.68341751,8.09763107 6.29289322,7.70710678 C5.90236893,7.31658249 5.90236893,6.68341751 6.29289322,6.29289322 L11.2928932,1.29289322 C11.6689749,0.916811528 12.2736364,0.900910387 12.6689647,1.25670585 L17.6689647,5.75670585 C18.0794748,6.12616487 18.1127532,6.75845471 17.7432941,7.16896473 C17.3738351,7.57947475 16.7415453,7.61275317 16.3310353,7.24329415 L12.0362375,3.37797611 Z" fill="#000000" fill-rule="nonzero"/>
						    </g>
						</svg><!--end::Svg Icon--></span>
        				<div class="text-info font-weight-bolder font-size-h2 mt-3 mb-4">Push</div>
        				 <form method="post" action="{{route($app->module.'.devmode.zip',$app->id)}}?s3=1&code=1" enctype="multipart/form-data">
			            
				                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
				                  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

				                  <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
				                  <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
				            <input type="hidden" name="theme_id" value="{{ $app->id }}">
				            <button type="submit" class="btn btn-outline-info btn-sm  font-weight-bold mt-2">All Files</button>
				        </form>
        				  <form method="post" action="{{route($app->module.'.devmode.zip',$app->id)}}?code=1" enctype="multipart/form-data">
			            
				                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
				                  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

				                  <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
				                  <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
				            <input type="hidden" name="theme_id" value="{{ $app->id }}">
				            <button type="submit" class="btn btn-outline-info btn-sm  font-weight-bold mt-2">Code</button>
				        </form>
				         <form method="post" action="{{route($app->module.'.devmode.zip',$app->id)}}?s3=1" enctype="multipart/form-data">
				            
				                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
				                  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

				                  <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
				                  <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
				            <input type="hidden" name="theme_id" value="{{ $app->id }}">
				            <button type="submit" class="btn btn-outline-info btn-sm  font-weight-bold mt-2">Assets</button>
				        </form>

        			</div>
        		</div>
        		<!--end::Tiles Widget 11-->

        	</div>

        				</div>
        				<p class="mb-0"><b>Note: </b> Pull 'All files' will activate devmode and and push will deactivate it.</p>
        			</div>
        		</div>
        	</div>
        	@endenv
        	
        </div>


    	</div>
	</div>


</x-dynamic-component>