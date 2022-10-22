<x-dynamic-component :component="$app->componentName" class="mt-4" >



<div class="row">
  <div class="col-12 col-md-10">
      <!--begin::Indexcard-->
      <div class="card mb-4">
        <div class="card-body bg-light">
          <h2 class="card-title mb-0">Documents</h2>
        </div>

         <div class="table-responsive mb-5">
          <table class="table table-bordered mb-0">
            <thead>
              <tr class="">
                <th scope="col">#</th>
                <th scope="col">Document</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody class="">
              <tr>
                <td>1</td>
                <td> PacketPrep Counselling - FAQ </td>
                <td> <a href="https://drive.google.com/file/d/1DWjf8ifEMVF1-9Npu3DGjag4sc2U2g2Y/view?usp=sharing" class="btn btn-success" target="_blank">View Document</a></td>
              </tr>
              <tr>
                <td>2</td>
                <td> PacketPrep Brochure </td>
                <td> <a href="https://drive.google.com/file/d/1sWL6T9JdGAPfIjfztlXVFyXyCnhKtvE2/view?usp=sharing" class="btn btn-success" target="_blank">View Document</a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!--end::Indexcard-->
  </div>
  <div class="col-12 col-md-2">
      <h3 class="mt-5 mt-md-0">Menu</h3>
      <div class="list-group">
        <a href="{{ route('Call.index')}}" class="list-group-item list-group-item-action ">
          Dashboard
        </a>
        <a href="{{ route('Call.documents')}}" class="list-group-item list-group-item-action active">Documents</a>
        <a href="{{ route('Call.tutorials')}}" class="list-group-item list-group-item-action ">Tutorials</a>
      </div>
  </div>
</div>


       


</x-dynamic-component>