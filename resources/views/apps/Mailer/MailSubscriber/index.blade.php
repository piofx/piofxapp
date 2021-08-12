<x-dynamic-component :component="$app->componentName" class="mt-4" >

  <!--begin::Breadcrumb-->
  <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
      <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
      <a href=""  class="text-muted">{{ ucfirst($app->module) }}</a>
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
          <h1 class="">Subscribers</h1>
          <h6 class="m-0 text-muted">Showing <span class="text-primary">{{ $objs->count() }}</span> Records</h6>
          </a> 
        </div>
        <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
           <div class="d-flex align-items-center">
              <a href="{{ route('MailCampaign.index') }}" class="btn btn-light-danger font-weight-bold ml-lg-2">Campaigns</a>
              <a href="{{ route('MailLog.index') }}" class="btn btn-light-info font-weight-bold ml-lg-2">Mail Logs</a>
              <a href="{{ route('MailTemplate.index') }}" class="btn btn-light-warning font-weight-bold ml-lg-2">Templates</a>
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
        <!--begin::upload element-->
        <div class="card card-custom bgi-no-repeat  gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('/themes/metronic/media/svg/patterns/abstract-4.svg') }}">
        <div class="row pl-5">
        <div class="col-5  ml-10">
          <div class="card-body">
            <a href="#" class="card-title font-weight-bold text-muted text-hover-primary font-size-h5">Add Subscribers Records</a>
            <div class="font-weight-bold text-success mt-2 mb-2">Upload CSV file In The Sample Format Only</div>
            <div class="font-weight-bold text-primary mt-2 mb-2">Download The Sample Format Of CSV File
            <a href="{{ route($app->module.'.samplecsv') }}" class="btn btn-info btn-sm ml-2"><i class="fa fa-download p-0"></i></a>
            </div>
            <form method="post" action="{{route($app->module.'.upload')}}" enctype="multipart/form-data">
              <input type="file" class="form-control-file" name="file" id="exampleFormControlFile1" multiple>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
              <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
              <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
              <button type="submit" name="submit" class="btn btn-warning mt-4"><i class="la la-cloud"></i> Upload</button>
            </form>
          </div>
          </div>
          <div class="col-6">
          <div class="mt-8">
          <a href="#" class="card-title font-weight-bold text-muted text-hover-primary font-size-h5">Download Subscribers Data</a><br>
          <a href="{{ route($app->module.'.download')}}" class="text-muted"><button class="btn btn-danger mt-4"><i class="la la-download"></i>Download</button></a>
          </div>
          </div>
        </div>
      </div>
      <!--end::upload element-->
   
    <div class="bg-white p-3 rounded-lg shadow">
        <!-- Table -->
        <table class="table table-borderless bg-white">    
            <thead>
              <tr>
                <th scope="col" class="p-3">#</th>
                <th scope="col" class="p-3 text-decoration-none">Email</th>
                <th scope="col" class="p-3">Information</th>
                <th scope="col" class="p-3">Status</th>
                <th scope="col" class="p-3">Valid Email</th>
                <th scope="col" class="p-3">Created At</th>
                <th scope="col" class="p-3 text-secondary font-weight-bolder text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
               @foreach($objs as $key=>$obj)  
                  <tr>
                    <th scope="row">{{$i++}}</th>
                    <td>
                      <a href=" {{ route($app->module.'.show',$obj->id) }} ">
                      {{ $obj->email }}
                      </a>
                    </td>
                    <td>{{$obj->info}}</td>
                    <td class="px-3 align-middle"><span class="label label-lg font-weight-bold label-inline {{ $obj->status == 1 ? 'label-light-success' : 'label-light-danger' }}">{{ $obj->status == 1 ? "Active" : "Inactive" }}</span></td>
                    <td class="px-3 align-middle"><span class="label label-lg font-weight-bold label-inline {{ $obj->status == 1 ? 'label-light-info' : 'label-light-warning' }}">{{ $obj->valid_email == 1 ? "True" : "False" }}</span></td>
                    <td class="px-3 align-middle text-primary font-weight-bolder">{{ $obj->created_at ? $obj->created_at->diffForHumans() : '' }}</td>
                    <td class="px-3 d-flex align-items-center justify-content-center align-middle">  
                    
                    <!-- View Button-->
                    <a href="{{ route($app->module.'.show', $obj->id) }}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2"><i class="fas fa-eye m-0"></i></a>
                    <!-- End View Button -->
                    <!-- Edit Button -->
                    <form action="{{ route($app->module.'.edit', $obj->id) }}">
                        <button class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" type="submit"><i class="fas fa-edit m-0"></i></button> 
                    </form>
                    <!-- End Edit Button -->

                    <!-- Confirm Delete Modal Trigger -->
                    <a href="#" data-toggle="modal" class="btn btn-sm btn-default btn-text-primary btn-hover-danger btn-icon mr-2" data-target="#staticBackdrop-{{$obj->id}}"><i class="fas fa-trash-alt m-0"></i></a>
                    <!-- End Confirm Delete Modal Trigger -->
                  </tr>
                
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
             @endforeach
          </table>
          {{ $objs->links() }}
    </div>
      

  <!--end::Table-->
</x-dynamic-component>