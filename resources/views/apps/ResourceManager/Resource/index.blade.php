<x-dynamic-component :component="$app->componentName">
    <div class="container-fluid my-5">
        <!-- Actions -->
        <div class="d-flex justify-content-between align-ites-center my-3">
            <div>
                <!-- Breadcrumbs -->
            </div> 
        </div>
     <!-- Table -->  
   <table class="table shadow-sm border">
        <thead class="thead-light">
        <tr>
        <td>
        <a href="{{ route($app->module.'.create') }}"> <button type="submit" class="btn btn-primary"><i class="fas fa-upload text-dark m-0"></i>Upload</button></a>
        </td>
        <td>
        <div>
           <div class="mx-auto pull-right">
            <div class="">
                <form action="{{ route('Resource.index') }}" method="GET" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control mr-2" name="item" placeholder="Search projects" id="item">
                            <span class="input-group-btn mr-5 mt-1">
                                <button class="btn btn-info" type="submit" title="Search projects">
                                    <span class="fas fa-search"></span>
                                </button>
                            </span>
                            <a href="{{ route('Resource.index') }}" class=" mt-1">
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="button" title="Refresh page">
                                        <span class="fas fa-sync-alt"></span>
                                    </button>
                                </span>
                            </a>
                </form>
        </td>
        </tr>
        <tr>
            <th scope="col" class="p-3">#</th>
            <th scope="col" class="p-3">@sortablelink('title')</th>
            <th scope="col" class="p-3">@sortablelink('description')</th>
            <th scope="col" class="p-3">@sortablelink('created_at')</th>
            <th scope="col" class="p-3 text-center">Action</th>
        </tr>
        </thead>
        <tbody>
                @foreach($objs as $obj)
                <tr>
                    <th scope="row" class="px-3 align-middle">{{ $obj->id }}</th>
                    <td class="px-3 align-middle">{{ $obj->title }}</td>
                    <td class="px-3 align-middle">{{ $obj->description }}</td>
                    <td class="px-3 align-middle">{{ $obj->created_at }}</td>
                    <td class="px-3 align-middle">
                        <div class="d-flex align-items-center justify-content-center">
                            <!-- view Button -->
                            
                            <form action="{{ route($app->module.'.show', $obj->id) }}">
                                <button type="submit" class="btn btn-sm mr-2"><i class="fas fa-eye text-dark m-0"></i></button>
                            </form>
                            
                            <!-- End view Button -->
                            <!-- Download Button -->
                            <form action="{{ route($app->module.'.download', $obj->id) }}">
                                <button type="submit" class="btn btn-sm mr-2"><i class="fas fa-download text-info m-0"></i></button>
                            </form>
                            <!-- End Download Button -->
                            <!-- Edit Button -->
                            <form action="{{ route($app->module.'.edit', $obj->id) }}">
                                <button type="submit" class="btn btn-sm mr-2"><i class="fas fa-edit text-info m-0"></i></button>
                            </form>
                            <!-- End Edit Button -->

                            <!-- Confirm Delete Modal Trigger -->
                            <i class="fas fa-trash-alt text-danger m-0" type="button" data-toggle="modal" data-target="#staticBackdrop-{{$obj->id}}"></i>
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
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table -->
    </div>
</x-dynamic-component>