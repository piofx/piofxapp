<x-dynamic-component :component="$app->componentName" class="mt-4" >

 <!--begin::Alert-->
  @if($alert)
    <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
  @endif
  <!--end::Alert-->

  <!--begin::Breadcrumb-->
  <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
      <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
      <a href="{{ route('Contact.index')}}"  class="text-muted">{{ ucfirst($app->module) }}</a>
    </li>
  </ul>
  <!--end::Breadcrumb-->

	<!--begin::basic card-->
	<x-snippets.cards.basic>
      <h1 class="p-5 rounded border bg-light mb-3">Settings</h1>

      @if($stub=='Create')
      <form method="post" action="{{route('Contact.settings')}}" enctype="multipart/form-data">
      @else
      <form method="post" action="{{route('Contact.settings')}}" enctype="multipart/form-data">
      @endif  

      <div class="form-group ">
        <label for="formGroupExampleInput ">Settings (json format)</label>
        <div class="border">
          <div id="content" style="min-height: 400px"></div>
          <textarea id="content_editor" class="form-control border d-none" name="settings"  rows="5">@if($stub=='Create'){{ (old('settings')) ? old('settings') : '' }}@else{{ json_encode(json_decode($data),JSON_PRETTY_PRINT) }}@endif
          </textarea>
        </div>
      </div>

      <input type="hidden" name="setting" value="0">
      <input type="hidden" name="store" value="1">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
        <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
       <button type="submit" class="btn btn-info">Save</button>
    </form>
    
	</x-snippets.cards.basic>
	<!--end::basic card-->   

</x-dynamic-component>