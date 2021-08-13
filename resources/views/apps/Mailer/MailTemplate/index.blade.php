<x-dynamic-component :component="$app->componentName">

    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
        <li class="breadcrumb-item">
            <a href="/admin" class="text-muted text-decoration-none">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#"  class="text-muted text-decoration-none">{{ ucfirst($app->app) }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#"  class="text-muted text-decoration-none">{{ ucfirst($app->module) }}</a>
        </li>
    </ul>
    <!--end::Breadcrumb-->
    <!--begin::Alert-->
	@if($alert)
	  <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
	@endif
	<!--end::Alert-->
    <!-- Actions -->
    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-success">
        <div class="card-body">
        <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
            <div class="d-flex flex-column mr-2">
            <a href="#" class="h2 text-dark text-hover-primary mb-0">
            <h1 class="">Templates</h1>
            <h6 class="m-0 text-muted">Showing <span class="text-primary">{{ $objs->count() }}</span> Records</h6>
            </a> 
            </div>
            <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
            <div class="d-flex align-items-center">
                <a href="{{ route('MailCampaign.index') }}" class="btn btn-light-danger font-weight-bold ml-lg-2">Campaigns</a>
                <a href="{{ route('MailLog.index') }}" class="btn btn-light-info font-weight-bold ml-lg-2">Mail Logs</a>
                <a href="{{ route('MailSubscriber.index') }}" class="btn btn-light-warning font-weight-bold ml-lg-2">Subscribers</a>
                <form action="{{ route($app->module.'.index') }}" method="GET">
                    <input type="text" name="query" class="form-control ml-1" placeholder="Search..">
                </form>
                <a href="{{ route($app->module.'.create') }}" class="btn btn-light-primary font-weight-bold mx-2 d-flex align-items-center"><i class="fas fa-plus fa-sm"></i> Add Record</a>
                </div>
            </div>
        </div>
        </div>
    </div>
    <!-- End Actions -->

    <div class="bg-white p-3 rounded-lg shadow">
        <!-- Table -->
        @if($objs->count() == 0)
                <div class="card card-body bg-white">
                    <h4 class="bg-light p-5 border broder-rounded text-center text-danger">No items found</h4>
                </div>
        @else
        <table class="table table-borderless bg-white">
            <tr class="border-bottom">
                <th scope="col" class="p-3">#</th>
                <th scope="col" class="p-3 text-decoration-none">Name</th>
                <th scope="col" class="p-3">Slug</th>
                <th scope="col" class="p-3">Subject</th>
                <th scope="col" class="p-3">Status</th>
                <th scope="col" class="p-3">Created At</th>
                <th scope="col" class="p-3 text-secondary font-weight-bolder text-center">Actions</th>
            </tr>
            @foreach($objs as $key => $obj)
                <tr class="border-bottom">
                    <td class="px-3 align-middle font-weight-bolder">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</td>
                    <td class="px-3 align-middle">{{ $obj->name }}</td>
                    <td class="px-3 align-middle">@if($obj->slug) {{ $obj->slug }}  @endif</td> 
                    <td class="px-3 align-middle">{{ $obj->subject }}</td>
                    <td class="px-3 align-middle"><span class="label label-lg font-weight-bold label-inline {{ $obj->status == 1 ? 'label-light-success' : 'label-light-danger' }}">{{ $obj->status == 1 ? "Active" : "Inactive" }}</span></td>
                    <td class="px-3 align-middle text-primary font-weight-bolder">{{ $obj->created_at ? $obj->created_at->diffForHumans() : '' }}</td>
                    <td class="px-3 d-flex align-items-center justify-content-center align-middle">  
                    
                    <!-- View Button-->
                    <a href="{{ route($app->module.'.show', $obj->slug) }}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2"><i class="fas fa-eye m-0"></i></a>
                    <!-- End View Button -->
                    <!-- Edit Button -->
                    <form action="{{ route($app->module.'.edit', $obj->slug) }}">
                        <button class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" type="submit"><i class="fas fa-edit m-0"></i></button> 
                    </form>
                    <!-- End Edit Button -->

                    <!-- Confirm Delete Modal Trigger -->
                    <a href="#" data-toggle="modal" class="btn btn-sm btn-default btn-text-primary btn-hover-danger btn-icon mr-2" data-target="#staticBackdrop-{{$obj->slug}}"><i class="fas fa-trash-alt m-0"></i></a>
                    <!-- End Confirm Delete Modal Trigger -->
                </tr>
                <!-- Confirm Delete Modal -->
                <div class="modal fade" id="staticBackdrop-{{$obj->slug}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                    <form action="{{ route($app->module.'.destroy', $obj->slug) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Confirm Delete Modal -->
            @endforeach
        @endif
        </table>   
        {{ $objs->links() }}
    </div>
</x-dynamic-component>