<x-dynamic-component :component="$app->componentName" class="mt-4" >
	
 <!--begin::Breadcrumb-->
  <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
      <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
      <a href="{{ route('College.index')}}"  class="text-muted">{{ ucfirst($app->module) }}</a>
    </li>
  </ul>
  <!--end::Breadcrumb-->
	<!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->

	<div class="page_wrapper">
		<div class="page_container">
			<div class="bg-white p-5 rounded-lg mt-3">
		       <h3 class="p-3 rounded-sm border bg-light">Upload College Data (CSV)</h3>
		       <form method="post" class="url_codesave" action="{{route('College.upload')}}" enctype="multipart/form-data">
				   <div class="form-group bg-light border p-4">
		            <label for="exampleFormControlFile1">Upload File</label>
		            <input type="file" class="form-control-file" name="file" id="exampleFormControlFile1">
		          </div>
		        <input type="hidden" name="_token" value="{{ csrf_token() }}">
				   <button type="submit" class="btn btn-primary mb-2">Send</button>
				</form>
		 	</div>

		</div>
	</div>

	<div class="border p-4 rounded mt-4">
			<h3> Sample CSV Files</h3>
			<ul>
				<li>College Data file - <a href="/college_data.csv">download</a></li>
			</ul>
		</div>
</x-dynamic-component>