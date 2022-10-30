<x-dynamic-component :component="$app->componentName" class="mt-4" >



<div class="row">
  <div class="col-12 col-md-10">
      <!--begin::Indexcard-->
      <div class="card mb-4">
        <div class="card-body bg-light">
         
          <h2 class="card-title mb-0">Tutorials</h2>
        </div>
      </div>
      <!--end::Indexcard-->
      <div class="mt-4">

      <div class="row">
        <div class="col-12 col-md-6">
          <div class="embed-responsive embed-responsive-16by9 mb-4">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/Fo5JJF88Trw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="embed-responsive embed-responsive-16by9 mb-4">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/jOOhkDrEJWc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
         <div class="col-12 col-md-6">
          <div class="embed-responsive embed-responsive-16by9 mb-4">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/02PEeDX0l0M" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="embed-responsive embed-responsive-16by9 mb-4">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/UIcaVuHjJns" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
         <div class="col-12 col-md-6">
          <div class="embed-responsive embed-responsive-16by9 mb-4">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/L7d_bTPudUE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
      </div>
      </div>
  </div>
  <div class="col-12 col-md-2">
      <h3 class="mt-5 mt-md-0">Menu</h3>
      <div class="list-group">
        <a href="{{ route('Call.index')}}" class="list-group-item list-group-item-action ">
          Dashboard
        </a>
        <a href="{{ route('Call.documents')}}" class="list-group-item list-group-item-action">Documents</a>
        <a href="{{ route('Call.tutorials')}}" class="list-group-item list-group-item-action active">Tutorials</a>
      </div>
  </div>
</div>


       


</x-dynamic-component>