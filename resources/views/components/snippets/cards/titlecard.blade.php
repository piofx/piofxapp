@props(['appid' => 0,'title'=>'Default','action'=>'url','module'=>'mod','obj'=>'obj','id'=>'id','preview'=>'0'])

<!--begin::Titlecard-->
<div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-warning">
 <div class="card-body">
  <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
   <div class="d-flex flex-column mr-5">
    <a href="#" class="h2 text-dark text-hover-primary mb-0">
    {{$title}}
    </a> 
   </div>
   <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
   @can('update',$obj)

   @if($preview)
   <a href="{{ $preview }}" class="btn btn-info"  target="_blank">
      <i class="flaticon-eye"></i> Preview
   </a>
   @endif

   @if($appid)
   <a href="{{ route($module.'.edit',[$appid,$id]) }}" class="btn btn-warning"  >
    	<i class="flaticon-edit"></i> Edit
	 </a>
   @else
   <a href="{{ route($module.'.edit',$id) }}" class="btn btn-warning"  >
      <i class="flaticon-edit"></i> Edit
   </a>
   @endif

   <a href="#" class="btn btn-danger"  data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" >
    	<i class="flaticon-delete"></i> Delete
	 </a>
	 @endcan
   </div>
  </div>
 </div>
</div>


<!-- Delete Modal-->
<div class="modal fade" id="exampleModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                This following action is permanent and it cannot be reverted.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                @if($appid)
                <form method="post" action="{{route($module.'.destroy',[$appid,$id])}}">
                @else
                <form method="post" action="{{route($module.'.destroy',$id)}}">
                @endif
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-danger">Delete Permanently</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!--end::Titlecard-->