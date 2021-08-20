<x-dynamic-component :component="$app->componentName">

    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
        <li class="breadcrumb-item">
            <a href="/admin" class="text-muted text-decoration-none">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/admin/blog"  class="text-muted text-decoration-none">{{ ucfirst($app->app) }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#"  class="text-muted text-decoration-none">{{ ucfirst($app->module) }}</a>
        </li>
    </ul>
    <!--end::Breadcrumb-->

    <!-- Actions -->
    <div class="d-block d-lg-flex justify-content-between align-items-center bg-white p-5 rounded shadow-sm mb-3">
        <div>
            <div class="d-flex align-items-center mb-1 mb-lg-3">
                <h1 class="m-0 text-dark d-inline">Blog</h1>
                <a href="{{ route('Settings.index') }}" class="btn btn-transparent-primary btn-sm ml-2"><i class="fas fa-cog p-0"></i> Settings</a>
            </div>
            <h6 class="m-0 text-muted">Showing <span class="text-primary">{{ $objs->total() }}</span> Records</h6>
        </div>
        <div class="d-block d-lg-flex align-items-center mt-5 mt-lg-0">
            <form action="{{ route($app->module.'.list') }}" method="GET">
                <input type="text" name="query" class="form-control" placeholder="Search..">
            </form>
            <div class="d-flex align-items-center justify-content-between justify-content-md-start mt-3 mt-lg-0">
                <a href="{{ route('Category.index') }}" class="btn btn-light-info font-weight-bold ml-lg-2">Categories</a>
                <a href="{{ route('Tag.index') }}" class="btn btn-light-danger font-weight-bold ml-md-2">Tags</a>
                @if(!empty($templates))
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-light-primary font-weight-bold ml-md-2 d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus fa-sm"></i> Add Record
                        </button>
                        @foreach($templates as $template)
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a href="{{ route($app->module.'.create', 'template=none') }}" class="dropdown-item">No Template</a></li>
                                <li><a class="dropdown-item" href="{{ route($app->module.'.create', 'template='.$template) }}">{{ ucwords(str_replace('_', ' ', $template)) }}</a></li>
                            </ul>
                        @endforeach
                    </div>
                @else
                    <a href="{{ route($app->module.'.create', 'template=none') }}" class="btn btn-light-primary font-weight-bold ml-md-2 d-flex align-items-center"><i class="fas fa-plus fa-sm"></i> Add Record</a>
                @endif
            </div>
        </div>
    </div>
    <!-- End Actions -->

    <div class="bg-white p-3 rounded-lg shadow table-responsive">
        <!-- Table -->
        <table class="table table-borderless bg-white">
            <tr class="border-bottom">
                <th scope="col" class="p-3">#</th>
                <th scope="col" class="p-3 text-decoration-none">Title</th>
                <th scope="col" class="p-3">Slug</th>
                <th scope="col" class="p-3">Category</th>
                <th scope="col" class="p-3">Tags</th>
                <th scope="col" class="p-3">Status</th>
                <th scope="col" class="p-3">Created At</th>
                <th scope="col" class="p-3 text-secondary font-weight-bolder text-center">Actions</th>
            </tr>
            @foreach($objs as $key=>$obj)
                <tr class="border-bottom">
                    <th scope="row" class="px-3 align-middle">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                    <td class="px-3 align-middle font-weight-bolder"><a href="@if(!empty($route)){{ $route.'/'.$obj->slug }}@else{{ route($app->module.'.show', $obj->slug) }}@endif" class="text-dark">{{ $obj->title }}</a></td>
                    <td class="px-3 align-middle">{{ $obj->slug }}</td>
                    
                    <td class="px-3 align-middle">@if($obj->category) {{ $obj->category->name }}  @endif</td>
                    
                    
                    <td class="px-3 align-middle">@if($obj->tags) @foreach($obj->tags as $tag){{ $tag->name.', ' }}@endforeach @endif</td>
                    
                    <td class="px-3 align-middle"><span class="label label-lg font-weight-bold label-inline {{ $obj->status == 1 ? 'label-light-success' : 'label-light-danger' }}">{{ $obj->status == 1 ? "Active" : "Inactive" }}</span></td>
                    <td class="px-3 align-middle text-primary font-weight-bolder">{{ $obj->created_at ? $obj->created_at->diffForHumans() : '' }}</td>
                    <td class="px-3 d-flex align-items-center justify-content-center align-middle">
                        <!-- View Button-->
                        <a href="@if(!empty($route)){{ $route.'/'.$obj->slug }}@else{{ route($app->module.'.show', $obj->slug) }}@endif" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2"><i class="fas fa-eye m-0"></i></a>
                        <!-- End View Button -->

                        <!-- Edit Button -->
                        @can('update', $obj)
                        <form action="{{ route($app->module.'.edit', $obj->slug) }}">
                            <button class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" type="submit"><i class="fas fa-edit m-0"></i></button> 
                        </form>
                        @endcan
                        <!-- End Edit Button -->

                        <!-- Confirm Delete Modal Trigger -->
                        @can('update', $obj)
                        <a href="#" data-toggle="modal" class="btn btn-sm btn-default btn-text-primary btn-hover-danger btn-icon mr-2" data-target="#staticBackdrop-{{$obj->id}}"><i class="fas fa-trash-alt m-0"></i></a>
                        @endcan
                        <!-- End Confirm Delete Modal Trigger -->
                        
                        <!-- Confirm Delete Modal -->
                        <div class="modal fade" id="staticBackdrop-{{$obj->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                    <form action="{{ route($app->module.'.destroy', $obj->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Confirm Delete Modal -->
                    </td>
                </tr>
            @endforeach
        </table>
        <!-- End Table -->
        <!-- Pagination -->
        {{$objs->links() ?? ''}}
        <!-- End Pagination -->
    </div>

</x-dynamic-component>