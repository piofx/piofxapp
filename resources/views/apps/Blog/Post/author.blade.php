<x-dynamic-component :component="$app->componentName"> 

    <div class="space-top-3 bg-light text-center">
        <div class="py-5">
            <div class="d-flex align-items-center justify-content-center">
                @if($author->image)
                    <div class="rounded-circle">
                        <@php
                            $path = explode("/", $author->image);
                            $path = explode(".", $path[1]);
                            $path = $path[0];
                        @endphp
                        <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}">
                    </div>
                @else
                    <h1 class="bg-soft-primary rounded-circle text-primary m-0 px-5 py-3">{{ strtoupper($author->name[0]) }}</h1>
                @endif
            </div>
            <h3 class="m-0 mt-3">{{ $author->name }}</h3>
            <p class="text-muted m-0">{{ $objs->total() }} Posts</p>
        </div>
    </div>

   <div class="container mt-5">
        <!-- Title -->
            <h2 class="text-center mt-5 mb-3">@if($settings->language == 'telugu') బ్లాగ్ పోస్ట్లు @else Blog Posts @endif</h2>
        <!-- End Title -->
        <div class="row mx-n2 mb-5 mb-md-9">
            @foreach($objs as $obj)
                <div class="col-sm-6 col-lg-3 px-2 mb-3 mb-lg-0 mt-3">
                    <!-- Card -->
                    <a class="card transition-3d-hover bg-soft-primary rounded-lg rounded-3" href="@if(!empty($route)){{ $route.'/'.$obj->slug }}@else{{ route($app->module.'.show', $obj->slug) }}@endif">
                        @if(!empty($obj->image) && strlen($obj->image) > 5)
                            @if(Storage::disk('s3')->exists($obj->image))
                                @php
                                    $path = explode("/", $obj->image);
                                    $path = explode(".", $path[1]);
                                    $path = $path[0];
                                @endphp
                                @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                    <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}">
                                @else
                                    <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($obj->image) }}">
                                @endif
                            @endif
                        @endif
                        <div class="card-body">
                            <span class="d-block small font-weight-bold text-cap mb-2">{{ $obj->category->name }}</span>
                            <h5 class="mb-0 text-dark">{{ $obj->title }}</h5>
                            @if(!$obj->image)
                                <p class="mt-3 text-muted">{{ $obj->excerpt }}</p>
                            @endif
                        </div>
                    </a>
                    <!-- End Card -->
                </div>
            @endforeach
        </div>
        {{ $objs->links() }}
   </div>

</x-dynamic-component>