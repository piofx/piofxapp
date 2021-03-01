<x-dynamic-component :component="$app->componentName">
    <div class=" my-5">

    @php
        function initials($str) {
            $ret = '';
            foreach (explode(' ', $str) as $word)
                $ret .= strtoupper($word[0]);
            return $ret;
        }
    @endphp   

        <div class="row">
            <div class="col-12 col-lg-9">
                <div class="bg-white p-5 rounded-lg shadow">
                    <div class="d-block d-lg-flex justify-content-between align-items-center">

                        <form action="{{ route($app->module.'.index', $filter) }}" class="bg-light text-dark d-flex justify-content-between align-items-center rounded pl-1 pr-3">
                            <input type="text" class="form-control bg-light text-dark border-0" placeholder="Search" name="search_query">
                            <i class="fas fa-search" type="submit"></i>
                        </form>

                        <form action="{{ route($app->module.'.create') }}" class="d-flex align-items-center">
                            <button type="submit" class="btn btn-light-primary font-weight-bold mt-3 mt-lg-0 ml-lg-2 d-flex align-items-center"><i class="fas fa-plus fa-sm"></i> Add Record</button>
                        </form>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-borderless bg-white mt-3 align-middle">
                            <tr class="bg-light align-middle">
                                <th scope="col" class="p-3">#</th>
                                <th scope="col" class="p-3 text-decoration-none">Name</th>
                                <th scope="col" class="p-3">Phone</th>
                                <th scope="col" class="p-3 text-center">Balance</th>
                                <th scope="col" class="p-3 text-center">Created</th>
                                <th scope="col" class="p-3 text-secondary font-weight-bolder text-center">Actions</th>
                            </tr>
                            @foreach($objs as $key=>$obj)
                                @php
                                    $remaining_credits = 0;

                                    foreach($obj->rewards as $reward){
                                        $remaining_credits = $remaining_credits + ($reward->credits - $reward->redeem);
                                    }
                                @endphp
                                <tr class="align-middle">
                                    <th scope="row" class="px-3 align-middle">{{ $objs->currentpage() ? ($objs->currentpage()-1) * $objs->perpage() + ( $key + 1) : $key+1 }}</th>
                                    <td class="px-3 py-3 font-weight-bolder align-middle">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <!--begin::Pic-->
                                            <div class="flex-shrink-0 mr-7">
                                                <div class="symbol symbol-light-danger">
                                                    <span class="font-size-h3 symbol-label font-weight-boldest">{{ initials($obj->name) }}</span>
                                                </div>
                                            </div>
                                            <!--end::Pic-->
                                            <div>
                                                <h5 class="m-0 font-weight-bolder"><a href="{{ route($app->module.'.show', $obj->id) }}" class="text-decoration-none text-dark">{{ $obj->name }}</a></h5>
                                                <span class="text-muted">{{ $obj->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 align-middle">{{ $obj->phone }}</td>
                                    <td class="px-3 align-middle text-center"><span class="label label-lg font-weight-bolder label-success label-inline">{{ $remaining_credits }}</span></td>
                                    <td class="px-3 align-middle text-primary font-weight-bolder text-center">{{ $obj->created_at ? $obj->created_at->diffForHumans() : '' }}</td>
                                    <td class="px-3 align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <!-- View Button-->
                                            <a href="{{ route($app->module.'.show', $obj->id) }}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2"><i class="fas fa-eye m-0"></i></a>
                                            <!-- End View Button -->

                                            @can('update', $obj)
                                            <!-- Edit Button -->
                                            <form action="{{ route($app->module.'.edit', $obj->id) }}">
                                                <button class="btn btn-sm btn-default btn-text-primary btn-hover-info btn-icon mr-2" type="submit"><i class="fas fa-edit m-0"></i></button> 
                                            </form>
                                            <!-- End Edit Button -->
                                            @endcan

                                            @can('delete', $obj)
                                                <!-- Confirm Delete Modal Trigger -->
                                                <a href="#" data-toggle="modal" class="btn btn-sm btn-default btn-text-primary btn-hover-danger btn-icon mr-2" data-target="#staticBackdrop-{{$obj->id}}"><i class="fas fa-trash-alt m-0"></i></a>
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
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <!-- End Table -->
                    <!-- Pagination -->
                    {{$objs->links()}}
                    <!-- End Pagination -->
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-5 mt-lg-0">
                @include('apps.Loyalty.snippets.sidemenu')
            </div>
        </div>

    </div>
</x-dynamic-component>