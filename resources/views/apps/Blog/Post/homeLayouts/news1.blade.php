<x-dynamic-component :component="$app->componentName">

    <div class="container space-top-3">
        <!-- Ad -->
        <div class="">
            @if(!empty($settings->ads))
                @foreach($settings->ads as $ad)
                    @if($ad->position == 'before-body')
                        {!! $ad->content !!}
                    @endif
                @endforeach
            @endif
        </div>
        <!-- End Ad Section -->

        <!-- Hero Section -->
        @if(!empty($featured))
            <div class=" mt-3">
                <div class="row">
                    @if($featured->count() > 3)
                        <div class="col-12 col-lg-8">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($featured as $k => $f)
                                        @if($k != 1 && $k != 2)
                                            <div class="carousel-item @if($k ==0) active @endif">             
                                                @if(!empty($f->image) && strlen($f->image) > 5 && Storage::disk('s3')->exists($f->image))
                                                    <article class="card mb-4">
                                                        <div style="max-height: 30rem; overflow: hidden;">
                                                            @php
                                                                $path = explode("/", $f->image);
                                                                $path = explode(".", $path[1]);
                                                                $path = $path[0];
                                                            @endphp
                                                            @if(Storage::disk('s3')->exists('resized_images/'.$path.'_resized.'.$ext))
                                                                <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_resized.'.$ext) }}">
                                                            @else
                                                                <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($f->image) }}">
                                                            @endif

                                                        </div>
                                                        <div class="card-body p-3 p-md-4">
                                                            @if($f->category)
                                                                <span class="d-block mb-2  mt-lg-0">
                                                                    <a class="font-weight-bold text-decoration-none text-primary " href="{{ route('Category.show', $f->category->slug) }}">{{ $f->category->name }}</a>
                                                                </span>
                                                            @endif
                                                            <h3><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$f->slug }}@else{{ route($app->module.'.show', $f->slug) }}@endif">{{$f->title}}</a></h3>

                                                            @if($f->excerpt)
                                                                <p>{!! substr($f->excerpt, 0, 200) !!}...</p>
                                                            @else
                                                                @php
                                                                    $content = strip_tags($f->content);
                                                                    $content = substr($content, 0 , 200);
                                                                @endphp
                                                                <p>{{ $content }}...</p>
                                                            @endif
                                                            <div>
                                                                <a href="@if(!empty($route)){{ $route.'/'.$f->slug }}@else{{ route($app->module.'.show', $f->slug) }}@endif" class="btn btn-primary">@if($settings->language == 'telugu') మరింత సమాచారం @else Continue Reading @endif</a>
                                                            </div>
                                                        </div>
                                                    </article>
                                                @else
                                                    <article class="card mb-4">
                                                        <div class="card-body p-3 p-md-4">
                                                            <a class="d-block small font-weight-bold text-cap mb-2" href="#">Business</a>

                                                            <h2 class="h3"><a class="text-inherit" href="#">Should Product Owners think like entrepreneurs?</a></h2>

                                                            @if($f->excerpt && strlen($f->excerpt) < 1500 )
                                                                <p>{!! substr($f->excerpt, 0, 1500) !!}...</p>
                                                            @else
                                                                @php
                                                                    $content = strip_tags($f->content);
                                                                    $content = substr($content, 0 , 1500);
                                                                @endphp
                                                                <p>{{ $content }}...</p>
                                                            @endif
                                                            <div class="mb-3">
                                                                @if($f->tags)
                                                                @foreach($f->tags as $tag)
                                                                    <a href="{{ route('Tag.show', $tag->slug) }}" class="badge rounded-badge bg-soft-primary px-2 py-1 text-primary">{{ $tag->name }}</a>
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                            <a href="@if(!empty($route)){{ $route.'/'.$f->slug }}@else{{ route($app->module.'.show', $f->slug) }}@endif" class="btn btn-primary">@if($settings->language == 'telugu') మరింత సమాచారం @else Continue Reading @endif</a>
                                                        </div>
                                                    </article>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Carousel Controls -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" style="height: 1rem;top:20rem" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" style="height: 1rem;top:20rem" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>

                        </div>
                        <div class="col-12 col-lg-4 pl-lg-0">
                            @foreach($featured as $k => $f)
                                @if($k == 1 || $k == 2)
                                    <article class="card mb-4">
                                            @if(!empty($f->image) && strlen($f->image) > 5 && Storage::disk('s3')->exists($f->image))
                                            <div style="max-height: 13.5rem;overflow: hidden;">
                                                @php
                                                    $path = explode("/", $f->image);
                                                    $path = explode(".", $path[1]);
                                                    $path = $path[0];
                                                @endphp
                                                @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                                    <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}">
                                                @else
                                                    <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($f->image) }}">
                                                @endif
                                            </div>
                                        @endif

                                        <div class="card-body p-3 p-md-4">
                                            @if($f->category)
                                                <span class="d-block mb-2 mt-3 mt-lg-0">
                                                    <a class="font-weight-bold text-decoration-none text-primary " href="{{ route('Category.show', $f->category->slug) }}">{{ $f->category->name }}</a>
                                                </span>
                                            @endif
                                            <h5><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$f->slug }}@else{{ route($app->module.'.show', $f->slug) }}@endif">{{$f->title}}</a></h5>
                                        </div>
                                    </article>
                                @endif 
                            @endforeach 
                        </div>
                    @else
                        <div class="col-12 col-lg-8">
                            @foreach($featured as $k => $f)
                                @if($k == 0)
                                    @if(!empty($f->image) && strlen($f->image) > 5 && Storage::disk('s3')->exists($f->image))
                                        <article class="card mb-4">
                                            <div style="max-height: 30rem; overflow: hidden;">
                                                @php
                                                    $path = explode("/", $f->image);
                                                    $path = explode(".", $path[1]);
                                                    $path = $path[0];
                                                @endphp
                                                @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                                    <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_resized.'.$ext) }}">
                                                @else
                                                    <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($f->image) }}">
                                                @endif
                                            </div>
                                            <div class="card-body p-3 p-md-4">
                                                @if($f->category)
                                                    <span class="d-block mb-2 mt-3 mt-lg-0">
                                                        <a class="font-weight-bold text-decoration-none text-primary " href="{{ route('Category.show', $f->category->slug) }}">{{ $f->category->name }}</a>
                                                    </span>
                                                @endif
                                                <h3><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$f->slug }}@else{{ route($app->module.'.show', $f->slug) }}@endif">{{$f->title}}</a></h3>

                                                @if($f->excerpt)
                                                    <p>{!! substr($f->excerpt, 0, 200) !!}...</p>
                                                @else
                                                    @php
                                                        $content = strip_tags($f->content);
                                                        $content = substr($content, 0 , 200);
                                                    @endphp
                                                    <p>{{ $content }}...</p>
                                                @endif
                                                <div>
                                                    <a href="@if(!empty($route)){{ $route.'/'.$f->slug }}@else{{ route($app->module.'.show', $f->slug) }}@endif" class="btn btn-primary">@if($settings->language == 'telugu') మరింత సమాచారం @else Continue Reading @endif</a>
                                                </div>
                                            </div>
                                        </article>
                                    @else
                                        <article class="card mb-4">
                                            <div class="card-body p-3 p-md-4">
                                                <a class="d-block small font-weight-bold text-cap mb-2" href="#">Business</a>

                                                <h2 class="h3"><a class="text-inherit" href="#">Should Product Owners think like entrepreneurs?</a></h2>

                                                @if($f->excerpt && strlen($f->excerpt) < 1500 )
                                                    <p>{!! substr($f->excerpt, 0, 1500) !!}...</p>
                                                @else
                                                    @php
                                                        $content = strip_tags($f->content);
                                                        $content = substr($content, 0 , 1500);
                                                    @endphp
                                                    <p>{{ $content }}...</p>
                                                @endif
                                                <div class="mb-3">
                                                    @if($f->tags)
                                                    @foreach($f->tags as $tag)
                                                        <a href="{{ route('Tag.show', $tag->slug) }}" class="badge rounded-badge bg-soft-primary px-2 py-1 text-primary">{{ $tag->name }}</a>
                                                    @endforeach
                                                    @endif
                                                </div>
                                                <a href="@if(!empty($route)){{ $route.'/'.$f->slug }}@else{{ route($app->module.'.show', $f->slug) }}@endif" class="btn btn-primary">@if($settings->language == 'telugu') మరింత సమాచారం @else Continue Reading @endif</a>
                                            </div>
                                        </article>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        <div class="col-12 col-lg-4 pl-lg-0">
                            @foreach($featured as $k => $f)
                                @if($k == 1 || $k == 2)
                                    <article class="card mb-4">
                                        @if(!empty($f->image) && strlen($f->image) > 5 && Storage::disk('s3')->exists($f->image))
                                            <div style="max-height: 13.5rem;overflow: hidden;">
                                                @php
                                                    $path = explode("/", $f->image);
                                                    $path = explode(".", $path[1]);
                                                    $path = $path[0];
                                                @endphp
                                                @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                                    <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}">
                                                @else
                                                    <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($f->image) }}">
                                                @endif
                                            </div>
                                        @endif

                                        <div class="card-body p-3 p-md-4">
                                            @if($f->category)
                                                <span class="d-block mb-2 mt-3 mt-lg-0">
                                                    <a class="font-weight-bold text-decoration-none text-primary" href="{{ route('Category.show', $f->category->slug) }}">{{ $f->category->name }}</a>
                                                </span>
                                            @endif
                                            <h5><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$f->slug }}@else{{ route($app->module.'.show', $f->slug) }}@endif">{{$f->title}}</a></h5>
                                        </div>
                                    </article>
                                @endif 
                            @endforeach 
                        </div>
                    @endif
                </div>  
            </div>  
        @endif  
        <!-- End Hero Section -->
    
        <!-- Blogs Section -->
        <div class="my-3">
            <div class="row justify-content-lg-between @if($featured->count() > 0) {{ '' }} @else {{ 'mt-5' }} @endif">
                <div class="col-12 col-lg-8"> 
                    <!-- Ad -->
                    <div class="mb-3">
                        @if(!empty($settings->ads))
                            @foreach($settings->ads as $ad)
                                @if($ad->position == 'before-content')
                                    {!! $ad->content !!}
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <!-- End Ad Section -->  

                    @foreach($categories as $category)
                        @if($category->posts->count() > 1)
                            <div class="mb-3">
                                <div class="mb-3 bg-soft-primary p-3 d-flex justify-content-between align-items-center rounded-lg rounded-3">
                                    <h5 class="p-0 m-0">{{ $category->name }}</h5>
                                    <a href="{{ route('Category.show', $category->slug) }}">@if($settings->language == "telugu" ) ఇంకా @else View all @endif &rarr;</a>
                                </div>
                                <div class="row">
                                    @foreach($category->posts->take(4) as $k => $obj)
                                        @if($obj->status != 0)
                                            <div class="col-6 col-lg-4 mb-3 @if($k == 1 || $k == 3) pl-0 @endif @if($k == 3) d-lg-none @endif">
                                                @if(!empty($obj->image) && strlen($obj->image) > 5 && Storage::disk('s3')->exists($obj->image))
                                                    <!-- Card -->
                                                    <div class="card transition-3d-hover">
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

                                                        <div class="card-body p-3 p-md-4">
                                                            <h5 class=""><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$obj->slug }}@else{{ route($app->module.'.show', $obj->slug) }}@endif">{{$obj->title}}</a></h5>
                                                            <div class="mb-3">
                                                                @if(!empty($tags))
                                                                    @foreach($tags as $tag)
                                                                        <a href="{{ route('Tag.show', $tag->slug) }}" class="badge rounded-badge bg-soft-primary px-2 py-1 text-primary">{{ $tag->name }}</a>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Card -->
                                                @else
                                                    <!-- Card -->
                                                    <div class="card transition-3d-hover bg-soft-info" href="#">
                                                        <div class="card-body p-3 p-md-4">
                                                            <h4 class="mb-0"><a href="@if(!empty($route)){{ $route.'/'.$obj->slug }}@else{{ route($app->module.'.show', $obj->slug) }}@endif" class="text-dark">{{ $obj->title }}</a></h4>
                                                            @if($obj->excerpt)
                                                                <p>{!! substr($f->excerpt, 0, 100) !!}...</p>
                                                            @else
                                                                @php
                                                                    $content = strip_tags($obj->content);
                                                                    $content = substr($content, 0 , 100);
                                                                @endphp
                                                                <p>{{ $content }}...</p>
                                                            @endif
                                                            <div class="mb-3">
                                                                @if(!empty($tags))
                                                                    @foreach($tags as $tag)
                                                                        <a href="{{ route('Tag.show', $tag->slug) }}" class="badge rounded-badge bg-soft-primary px-2 py-1 text-primary">{{ $tag->name }}</a>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Card -->
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    <!-- Ad -->
                    <div class="my-3">
                        @if(!empty($settings->ads))
                            @foreach($settings->ads as $ad)
                                @if($ad->position == 'after-content')
                                    {!! $ad->content !!}
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <!-- End Ad Section -->
                </div>

                <!-- Right Section -->
                <div class="col-12 col-lg-4 ">
                    <div class="mb-3">
                        <!-- Search Form -->
                        <form action="{{ route($app->module.'.search') }}" method="GET">
                            <div class="form-floating">
                                <input type="text" class="form-control form-control-lg input-text" placeholder="@if($settings->language == 'telugu') వెతకండి @else Search @endif..." name="query">
                                <label for="floatingInput">@if($settings->language == 'telugu') వెతకండి @else Search @endif...</label>
                            </div>
                        </form>
                        <!-- End Search Form -->
                    </div>

                    <!-- Ad -->
                    <div class="my-3">
                        @if(!empty($settings->ads))
                            @foreach($settings->ads as $ad)
                                @if($ad->position == 'sidebar-top')
                                    {!! $ad->content !!}
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <!-- End Ad Section -->

                    <!----- Tags section------>
                    <div class="my-3">
                        <h3 class="font-weight-bold mb-3">@if($settings->language == 'telugu') టాగ్లు @else Tags @endif</h3>
                        @foreach($tags as $tag)
                            <a class="btn btn-sm btn-outline-dark mb-1" href="{{ route('Tag.show', $tag->slug) }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                    <!----- End Tags Section------>

                    <div class="my-3">
                        <h3 class="my-3">@if($settings->language == 'telugu') ముఖ్య విశేషాలు @else Popular Posts @endif</h3>
                        <!-- Popular Posts -->
                        @foreach($popular as $post)     
                            @if($post->status)
                                @if(!empty($post->image) && strlen($post->image) > 5)
                                    @if(Storage::disk('s3')->exists($post->image))
                                        <!-- Related Post -->
                                        <div class="bg-soft-danger p-3 rounded-lg rounded-3 mb-3">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-4">
                                                    @php
                                                        $path = explode("/", $post->image);
                                                        $path = explode(".", $path[1]);
                                                        $path = $path[0];
                                                    @endphp
                                                    @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                                        <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}">
                                                    @else
                                                        <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($post->image) }}">
                                                    @endif
                                                </div>
                                                <div class="col-8 pl-0">
                                                    <h6 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'/$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h6>
                                                    <p class="text-muted m-0">{{ $post->created_at ? $post->created_at->diffForHumans() : "" }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Related Post -->
                                    @endif
                                @else
                                    <div class="bg-soft-danger p-3 rounded-lg rounded-3 mb-3">
                                        <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'/$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                        @if($post->excerpt)
                                            <p>{!! substr($post->excerpt, 0, 50) !!}...</p>
                                        @else
                                            @php
                                                $content = strip_tags($post->content);
                                                $content = substr($content, 0 , 50);
                                            @endphp
                                            <p>{{ $content }}...</p>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @endforeach
                        <!-- End Popular Posts -->

                        <!-- Ad -->
                        <div class="my-3">
                            @if(!empty($settings->ads))
                                @foreach($settings->ads as $ad)
                                    @if($ad->position == 'sidebar-bottom')
                                        {!! $ad->content !!}
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <!-- End Ad Section -->
                    </div>

                </div>
            </div>
            <!-- End of Row -->
            
            <!-- Ad -->
            <div class="my-3">
                @if(!empty($settings->ads))
                    @foreach($settings->ads as $ad)
                        @if($ad->position == 'after-body')
                            {!! $ad->content !!}
                        @endif
                    @endforeach
                @endif
            </div>
            <!-- End Ad Section -->
        </div>
        <!-- End Blogs Section -->
    </div>

</x-dynamic-component>