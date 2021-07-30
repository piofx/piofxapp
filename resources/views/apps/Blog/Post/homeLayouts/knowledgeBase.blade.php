<x-dynamic-component :component="$app->componentName">

    <!-- Check if browser supports webP format for images -->
    @php
        if( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {
            $ext = 'webp';
        }
        else{
            $webp = false;
        }
    @endphp
        
    <!-- Hero Section -->
    <div class="position-relative">
        <!-- Main Slider -->
        <div id="heroSlider" class="js-slick-carousel slick" data-hs-slick-carousel-options='{
            "vertical": true,
            "verticalSwiping": true,
            "infinite": true,
            "autoplay": true,
            "autoplaySpeed": 10000,
            "dots": true,
            "dotsClass": "slick-pagination slick-pagination-white slick-pagination-vertical d-lg-none position-absolute bottom-0 right-0 mb-3 mr-3",
            "asNavFor": "#heroSliderNav",
            "responsive": [
                {
                "breakpoint": 576,
                "settings": {
                    "vertical": false,
                    "verticalSwiping": false
                }
                }
            ]
            }'>

            @if(!empty($featured))
                @foreach($featured as $f)
                    @if($f->status != 0)
                        @if(!empty($f->image) && strlen($f->image) > 5 && Storage::disk('s3')->exists($f->image))
                            <div style="background-image: url({{ Storage::disk('s3')->url($f->image) }}); background-size: cover; backround-position: center; background-repeat: no-repeat;">
                                <div class="js-slide d-flex bg-img-hero min-h-620rem">
                                <!-- News Block -->
                                    <div class="container d-flex align-items-center min-h-620rem">
                                        <div class="w-lg-40 mr-5 rounded-lg p-4" style="background: rgba(0, 0, 0, 0.8);">
                                            <div class="mb-5">
                                                <h3 class="font-weight-bold text-danger" data-hs-slick-carousel-animation="fadeInUp"
                                                data-hs-slick-carousel-animation-delay="150">{{ $f->title }}</h3>

                                                @if($f->excerpt)
                                                    <p data-hs-slick-carousel-animation="fadeInUp"
                                                data-hs-slick-carousel-animation-delay="150" class="text-light">{!! substr($f->excerpt, 0, 100) !!}...</p>
                                                @else
                                                    @php
                                                        $content = strip_tags($f->content);
                                                        $content = substr($content, 0 , 100);
                                                    @endphp
                                                    <p data-hs-slick-carousel-animation="fadeInUp"
                                                data-hs-slick-carousel-animation-delay="150" class="text-light">{{ $content }}...</p>
                                                @endif                  
                                            </div>
                                            <a class="btn btn-primary btn-sm transition-3d-hover" href="{{ route($app->module.'.show', $f->slug) }}"
                                            data-hs-slick-carousel-animation="fadeInUp" data-hs-slick-carousel-animation-delay="300">Read Article<i
                                            class="fas fa-angle-right fa-sm ml-1"></i></a>
                                        </div>
                                    </div>
                                    <!-- End News Block -->
                                </div>
                            </div>
                        @else
                            <div class="js-slide bg-dark d-flex bg-img-hero min-h-620rem">
                                <!-- News Block -->
                                <div class="container d-flex align-items-center min-h-620rem">
                                    <div class="w-lg-40 mr-5">
                                    <!-- Author -->
                                    <div class="media align-items-center mb-3" data-hs-slick-carousel-animation="fadeInUp">
                                        @if($author->image)
                                            <div class="avatar avatar-circle">
                                                @php
                                                    $path = explode("/", $author->image);
                                                    $path = explode(".", $path[1]);
                                                    $path = $path[0];
                                                @endphp
                                                @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                                    <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}">
                                                @else
                                                    <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($author->image) }}">
                                                @endif
                                            </div>
                                        @else
                                            <div class="avatar avatar-circle bg-white text-dark d-flex align-items-center justify-content-center">
                                                <h3 class="m-0 p-0">{{ strtoupper($author->name[0]) }}</h3>
                                            </div>
                                        @endif
                                        <div class="media-body ml-2">
                                        <a class="text-white" href="{{ route('Post.author', $author->id) }}">{{ $author->name }}</a>
                                        </div>
                                    </div>
                                    <!-- End Author -->

                                    <div class="mb-5">
                                        <h3 class="font-weight-bold text-danger" data-hs-slick-carousel-animation="fadeInUp"
                                        data-hs-slick-carousel-animation-delay="150">{{ $f->title }}</h3>

                                        @if($f->excerpt)
                                            <p data-hs-slick-carousel-animation="fadeInUp"
                                        data-hs-slick-carousel-animation-delay="150" class="text-light">{!! substr($f->excerpt, 0, 100) !!}...</p>
                                        @else
                                            @php
                                                $content = strip_tags($f->content);
                                                $content = substr($content, 0 , 100);
                                            @endphp
                                            <p data-hs-slick-carousel-animation="fadeInUp"
                                        data-hs-slick-carousel-animation-delay="150" class="text-light">{{ $content }}...</p>
                                        @endif                  </div>
                                    <a class="btn btn-primary btn-sm transition-3d-hover" href="{{ route($app->module.'.show', $f->slug) }}"
                                        data-hs-slick-carousel-animation="fadeInUp" data-hs-slick-carousel-animation-delay="300">Read Article<i
                                        class="fas fa-angle-right fa-sm ml-1"></i></a>
                                    </div>
                                </div>
                                <!-- End News Block -->
                            </div>
                        @endif
                    @endif
                @endforeach
            @endif
        </div>
        <!-- End Main Slider -->

        <!-- Slider Nav -->
        <div class="container slick-pagination-line-wrapper content-centered-y right-0 left-0">
            <div class="content-centered-y right-0 mr-3">
                <div id="heroSliderNav" class="js-slick-carousel slick slick-pagination-line max-w-27rem ml-auto"
                    data-hs-slick-carousel-options='{
                    "vertical": true,
                    "verticalSwiping": true,
                    "infinite": true,
                    "autoplay": true,
                    "autoplaySpeed": 10000,
                    "slidesToShow": 3,
                    "isThumbs": true,
                    "asNavFor": "#heroSlider"
                    }'>
                    @foreach($featured as $f)
                        @if($f->status != 0)
                            <div class="js-slide my-1 bg-white rounded-lg p-2">
                                <span class="text-dark">{{ substr($f->title, 0, 20) }}</span>
                                <span class="slick-pagination-line-progress bg-dark">
                                    <span class="slick-pagination-line-progress-helper"></span>
                                </span>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
        <!-- End Slider Nav -->
    </div>
    <!-- End Hero Section -->
    
    <!-- Blogs Section -->
    <div class="container space-1 @if(!($featured->count() > 0)) {{ 'space-top-3' }} @endif">
        <div class="row justify-content-lg-between @if($featured->count() > 0) {{ '' }} @else {{ 'mt-5' }} @endif">
            <div class="col-12 col-lg-9">

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

                @foreach($objs as $obj)
                    @if($obj->status != 0)
                        <!-- Blog -->
                        @if(!empty($obj->image) && strlen($obj->image) > 5 && Storage::disk('s3')->exists($obj->image))
                            <div class="mb-5 p-3 bg-light rounded-lg">
                                <div class="row">
                                    <div class="col-md-5 d-flex align-items-center">
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
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body d-flex flex-column h-100 p-0">
                                            @if($obj->category)
                                                <span class="d-block mb-2 mt-3 mt-lg-0">
                                                    <a class="font-weight-bold text-decoration-none text-primary " href="{{ route('Category.show', $obj->category->slug) }}">{{ $obj->category->name }}</a>
                                                </span>
                                            @endif
                                            <h3><a class="text-decoration-none text-dark" href="{{ route($app->module.'.show', $obj->slug) }}">{{$obj->title}}</a></h3>
                                            @if($obj->excerpt)
                                                <p>{!! substr($obj->excerpt, 0, 200) !!}...</p>
                                            @else
                                                @php
                                                    $content = strip_tags($obj->content);
                                                    $content = substr($content, 0 , 200);
                                                @endphp
                                                <p>{{ $content }}...</p>
                                            @endif
                                            <div class="mb-3">
                                                @if($obj->tags)
                                                @foreach($obj->tags as $tag)
                                                    <a href="{{ route('Tag.show', $tag->slug) }}" class="badge rounded-badge bg-soft-primary px-2 py-1">{{ $tag->name }}</a>
                                                @endforeach
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ route($app->module.'.show', $obj->slug) }}" class="btn btn-sm btn-primary">@if($settings->language == 'telugu') మరింత సమాచారం @else Continue Reading @endif</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-5 p-3 bg-light rounded-lg">
                                <div class="card-body d-flex flex-column h-100 p-0">
                                    @if($obj->category)
                                        <span class="d-block mb-2">
                                        <a class="font-weight-bold text-decoration-none text-primary" href="{{ route('Category.show', $obj->category->slug) }}">{{ $obj->category->name }}</a>
                                        </span>
                                    @endif
                                    <h3><a class="text-decoration-none text-dark" href="{{ route($app->module.'.show', $obj->slug) }}">{{$obj->title}}</a></h3>
                                    @if($obj->excerpt)
                                        <p>{!! $obj->excerpt !!}...</p>
                                    @else
                                        @php
                                            $content = strip_tags($obj->content);
                                            $content = substr($content, 0 , 200);
                                        @endphp
                                        <p>{{ $content }}...</p>
                                    @endif
                                    <div class="mb-3">
                                        @if($obj->tags)
                                        @foreach($obj->tags as $tag)
                                            <a href="{{ route('Tag.show', $tag->slug) }}" class="badge rounded-badge bg-soft-primary px-2 py-1">{{ $tag->name }}</a>
                                        @endforeach
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route($app->module.'.show', $obj->slug) }}" class="btn btn-sm btn-primary">@if($settings->language == 'telugu') మరింత సమాచారం @else Continue Reading @endif</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- End Blog -->
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
                <div class="my-3">
                    {{$objs->links() ?? ""}}
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-12 col-lg-3">
                <div class="mb-5">
                    <!-- Search Form -->
                    <form action="{{ route($app->module.'.search') }}" method="GET">
                        <div class="input-group mb-3"> 
                            <input type="text" class="form-control input-text" placeholder="@if($settings->language == 'telugu') వెతకండి @else Search @endif..." name="query">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary btn-md" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- End Search Form -->
                </div>

                <!-- Ad -->
                <div class="my-5">
                    @if(!empty($settings->ads))
                        @foreach($settings->ads as $ad)
                            @if($ad->position == 'sidebar-top')
                                {!! $ad->content !!}
                            @endif
                        @endforeach
                    @endif
                </div>
                <!-- End Ad Section -->

                <!---------Categories section-----> 
                <div class="my-5">
                    <h3 class="font-weight-bold mb-3">Categories</h3>
                    <div class="list-group">
                        @foreach($categories as $category)
                            @if($category->posts->count() > 0)
                                <a type="button" href="{{ route('Category.show', $category->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" aria-current="true">
                                {{ $category->name }}<span class="badge bg-primary text-white rounded-pill">{{ $category->posts->count() }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <!--------- End categories section----->

                <!----- Tags section------>
                <div class="my-5">
                    <h3 class="font-weight-bold mb-3">Tags</h3>
                    @foreach($tags as $tag)
                        <a class="btn btn-sm btn-outline-dark mb-1" href="{{ route('Tag.show', $tag->slug) }}">{{ $tag->name }}</a>
                    @endforeach
                </div>
                <!----- End Tags Section------>

                <div class="my-5">
                    <h3 class="mb-3">Popular Posts</h3>
                    <!-- Popular Posts -->
                    @foreach($popular as $post)     
                        @if($post->status)
                            @if(!empty($post->image) && strlen($post->image) > 5)
                                @if(Storage::disk('s3')->exists($post->image))
                                    <!-- Related Post -->
                                    <div class="bg-soft-danger p-3 rounded-lg mb-3">
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
                                                <h6 class="mb-0"><a class="text-decoration-none text-dark" href="{{ route($app->module.'.show', $post->slug) }}">{{ $post->title }}</a></h6>
                                                <p class="text-muted m-0">{{ $post->created_at ? $post->created_at->diffForHumans() : "" }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Related Post -->
                                @endif
                            @else
                                <div class="bg-soft-danger p-3 rounded-lg mb-3">
                                    <h5 class="mb-0"><a class="text-decoration-none text-dark" href="{{ route($app->module.'.show', $post->slug) }}">{{ $post->title }}</a></h5>
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
                </div>

                <!-- Ad -->
                <div class="my-5">
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

</x-dynamic-component>