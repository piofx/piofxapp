<x-dynamic-component :component="$app->componentName">

    <div class="space-top-2">
        <div class="container mt-5 text-center">
                <!-- Info -->
                <div class="mt-7">
                    <h1 class="text-dark mb-3">@if($settings->language == 'telugu') శోధన ఫలితాలు @else Search Results @endif</h1>
                </div>
                <!-- End Info -->
                <!-- Form -->
                <form action="{{ route('Post.search') }}">
                    <div class="border-1 rounded-3 shadow d-flex align-items-center p-3">
                        <input type="text" class="form-control form-control-lg border-0 outline-0 shadow-none" name="query"
                                    placeholder="@if($settings->language == 'telugu') ఎడైనా వెతకండి @else Search Something @endif...">
                        <button type="submit" class="btn btn-outline-primary btn-lg">@if($settings->language == 'telugu') వెతకండి @else Search @endif</button>
                    </div>
                </form>
                <!-- End Form -->
        </div>
    </div>
    
    <!-- Results Section -->
    <div class="container space-1 mt-3">
        <h5 class="text-muted font-weight-bold m-0 p-0 mb-2 mt-4">Found <span class="text-primary fw-bold font-weight-bold">{{ $objs->total() }}</span> Matching Posts</h5>
        <div class="row ">
            @if($objs->isNotEmpty())
                @foreach($objs as $obj)
                <div class="col-sm-6 col-lg-4 px-2 px-lg-3 py-3 rounded-lg">
                    <!-- Card -->
                    <div class="card flex-wrap flex-row text-dark">
                        <div>
                            @if(!empty($obj->image) && strlen($obj->image) > 5)
                                @if(Storage::disk('s3')->exists($obj->image))
                                    <figure class="max-w-37rem w-100">
                                        @php
                                            $path = explode("/", $obj->image);
                                            $path = explode(".", $path[1]);
                                            $path = $path[0];
                                        @endphp
                                         @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.jpg'))
                                            <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.jpg') }}">
                                        @else
                                            <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($obj->image) }}">
                                        @endif
                                    </figure>
                                @endif
                            @endif
                            <div class="p-3">
                                <span class="d-block mb-2">
                                    <a class="font-weight-bold text-decoration-none text-primary" href="{{ route('Category.show', $obj->category->slug) }}">{{ $obj->category->name }}</a>
                                </span>
                                <h3>{{$obj->title}}</h3>
                                <p>{{$obj->excerpt}}</p>
                                <div class="mb-3">
                                    @foreach($obj->tags as $tag)
                                        <a href="{{ route('Tag.show', $tag->slug) }}" class="badge rounded-badge bg-soft-primary px-2 py-1 text-primary">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                                <a href="{{ route($app->module.'.show', $obj->slug) }}" class="btn btn-sm btn-primary">@if($settings->language == 'telugu') మరింత సమాచారం @else Continue Reading @endif</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Card -->
                </div>
                @endforeach
            @else
                <div class="container text-center p-3 my-5 bg-soft-danger">
                    <h3 class="text-danger">No posts Available</h3>
                </div>
            @endif
        </div>

        <div class="my-3">
            {{ $objs->appends(["query"=>request()->get('query'), "page"=>request()->get('page')])->links() }}
        </div>
    
    </div>

    <!-- End Results Section -->



</x-dynamic-component>