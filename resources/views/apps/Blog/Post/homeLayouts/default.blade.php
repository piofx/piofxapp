<x-dynamic-component :component="$app->componentName">
        


    <!-- Blogs Section -->
    <div class="container space-1 @if(!$featured_section) {{ 'space-top-2' }} @endif">
        <div class="row justify-content-lg-between @if($featured->count() > 0) {{ '' }} @else {{ 'mt-9 mt-md-10 mt-lg-8 ' }} @endif">
            <div class="col-12 col-lg-9">

                <div class="mb-5 d-block d-md-none" >
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
                @if(!empty($settings->ads))
                    <div class="mb-3">
                        @foreach($settings->ads as $ad)
                            @if($ad->position == 'before-content')
                                {!! $ad->content !!}
                            @endif
                        @endforeach
                    </div>
                @endif
                <!-- End Ad Section -->  

                <!-- featured -->
                @foreach($featured as $obj)
                    @if($obj->status != 0)
                        <!-- Blog -->
                        @if(!empty($obj->image) && strlen($obj->image) > 5 && Storage::disk('s3')->exists($obj->image))
                            <div class="mb-5 p-3 bg-soft-success border border-light-info shadow rounded-lg">
                                <div class="row">
                                    <div class="col-md-5 d-flex align-items-center">
                                        <a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$obj->slug }}@else{{ route($app->module.'.show', $obj->slug) }}@endif">
                                        @php
                                            $path = explode("/", $obj->image);
                                            $path = explode(".", $path[1]);
                                            $path = $path[0];
                                        @endphp
                                        @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                            <img class="img-fluid rounded-lg rounded-3 mb-2  mb-1" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}" alt="{{$obj->title}} - {{request()->get('client.name')}}">
                                        @else
                                            <img class="img-fluid rounded-lg rounded-3 mb-2  mb-1" src="{{ Storage::disk('s3')->url($obj->image) }}" alt="{{$obj->title}} - {{request()->get('client.name')}}">
                                        @endif
                                        </a>
                                    </div>

                                    <div class="col-md-7">

                                            <span class="badge badge-warning flex-row mb-2 float-right"><i class="fa fa-star text-warning"></i> Featured</span>
                                        <div class="card-body d-flex flex-column h-100 p-0">
                                            @if(!empty($obj->category) && strtolower($obj->category->name) != 'uncategorized')
                                                <span class="d-block mb-2 mt-3 mt-lg-2">
                                                    <a class="font-weight-bold text-decoration-none text-primary " href="{{ route('Category.show', $obj->category->slug) }}">{{ $obj->category->name }}</a>
                                                </span>
                                            @endif
                                            <h3><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$obj->slug}}@else{{ route($app->module.'.show', $obj->slug) }}@endif">{{$obj->title}}</a></h3>
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
                                                <a href="@if(!empty($route)){{ $route.'/'.$obj->slug}}@else{{ route($app->module.'.show', $obj->slug) }}@endif" class="btn btn-sm btn-primary">@if($settings->language == 'telugu') మరింత సమాచారం @else Continue Reading @endif</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-5 p-3 bg-white shadow rounded-lg">
                                <div class="card-body d-flex flex-column h-100 p-0">
                                    @if(!empty($obj->category) && strtolower($obj->category->name) != 'uncategorized')
                                        <span class="d-block mb-2">
                                        <a class="font-weight-bold text-decoration-none text-primary" href="{{ route('Category.show', $obj->category->slug) }}">{{ $obj->category->name }}</a>
                                        </span>
                                    @endif
                                    <h3><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$obj->slug}}@else{{ route($app->module.'.show', $obj->slug) }}@endif">{{$obj->title}}</a></h3>
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
                                        <a href="@if(!empty($route)){{ $route.'/'.$obj->slug}}@else{{ route($app->module.'.show', $obj->slug) }}@endif" class="btn btn-sm btn-primary">@if($settings->language == 'telugu') మరింత సమాచారం @else Continue Reading @endif</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- End Blog -->
                    @endif
                @endforeach

                @foreach($objs as $obj)
                    @if($obj->status != 0)
                        <!-- Blog -->
                        @if(!empty($obj->image) && strlen($obj->image) > 5 && Storage::disk('s3')->exists($obj->image))
                            <div class="mb-5 p-3 bg-white shadow rounded-lg">
                                <div class="row">
                                    <div class="col-md-5 d-flex align-items-center">
                                        <a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$obj->slug }}@else{{ route($app->module.'.show', $obj->slug) }}@endif">
                                        @php
                                            $path = explode("/", $obj->image);
                                            $path = explode(".", $path[1]);
                                            $path = $path[0];
                                        @endphp
                                        @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                            <img class="img-fluid rounded-lg rounded-3 mb-2  mb-1" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}" alt="{{$obj->title}} - {{request()->get('client.name')}}">
                                        @else
                                            <img class="img-fluid rounded-lg rounded-3 mb-2  mb-1" src="{{ Storage::disk('s3')->url($obj->image) }}" alt="{{$obj->title}} - {{request()->get('client.name')}}">
                                        @endif
                                        </a>
                                    </div>

                                    <div class="col-md-7">
                                        <div class="card-body d-flex flex-column h-100 p-0">
                                            @if(!empty($obj->category) && strtolower($obj->category->name) != 'uncategorized')
                                                <span class="d-block mb-2 mt-3 mt-lg-2">
                                                    <a class="font-weight-bold text-decoration-none text-primary " href="{{ route('Category.show', $obj->category->slug) }}">{{ $obj->category->name }}</a>
                                                </span>
                                            @endif
                                            <h3><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$obj->slug}}@else{{ route($app->module.'.show', $obj->slug) }}@endif">{{$obj->title}}</a></h3>
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
                                                <a href="@if(!empty($route)){{ $route.'/'.$obj->slug}}@else{{ route($app->module.'.show', $obj->slug) }}@endif" class="btn btn-sm btn-primary">@if($settings->language == 'telugu') మరింత సమాచారం @else Continue Reading @endif</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-5 p-3 bg-white shadow rounded-lg">
                                <div class="card-body d-flex flex-column h-100 p-0">
                                    @if(!empty($obj->category) && strtolower($obj->category->name) != 'uncategorized')
                                        <span class="d-block mb-2">
                                        <a class="font-weight-bold text-decoration-none text-primary" href="{{ route('Category.show', $obj->category->slug) }}">{{ $obj->category->name }}</a>
                                        </span>
                                    @endif
                                    <h3><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$obj->slug}}@else{{ route($app->module.'.show', $obj->slug) }}@endif">{{$obj->title}}</a></h3>
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
                                        <a href="@if(!empty($route)){{ $route.'/'.$obj->slug}}@else{{ route($app->module.'.show', $obj->slug) }}@endif" class="btn btn-sm btn-primary">@if($settings->language == 'telugu') మరింత సమాచారం @else Continue Reading @endif</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- End Blog -->
                    @endif
                @endforeach

                <!-- Ad -->
                @if(!empty($settings->ads))
                    <div class="my-3">
                        @foreach($settings->ads as $ad)
                            @if($ad->position == 'after-content')
                                {!! $ad->content !!}
                            @endif
                        @endforeach
                    </div>
                @endif
                <!-- End Ad Section -->

                <!-- Pagination -->
                <div class="my-3 overflow-auto">
                    {{$objs->links() ?? ""}}
                </div>
                <!-- Pagination -->
            </div>

            <!-- Right Section -->
            <div class="col-12 col-lg-3">

                <!-- login -->
                @include('apps.Blog.Post.homeLayouts.login')
                <!-- end login -->
                
                <div class="mb-5 d-none d-md-block" >
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
                    @foreach($tags as $kt=>$tag)
                        <a class="btn btn-sm btn-soft-dark py-1 px-2 mr-1 mb-2" href="{{ route('Tag.show', $tag->slug) }}">{{ $tag->name }}</a>
                        @if($kt==6)
                            @break
                        @endif    
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
                                                <a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">
                                                @php
                                                    $path = explode("/", $post->image);
                                                    $path = explode(".", $path[1]);
                                                    $path = $path[0];
                                                @endphp
                                                @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                                    <img class="img-fluid rounded-lg rounded-3 mb-2 " src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                @else
                                                    <img class="img-fluid rounded-lg rounded-3 mb-2 " src="{{ Storage::disk('s3')->url($post->image) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                @endif
                                                </a>
                                            </div>
                                            <div class="col-8 pl-0">
                                                <h6 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h6>
                                                <p class="text-muted m-0">{{ $post->created_at ? $post->created_at->diffForHumans() : "" }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Related Post -->
                                @endif
                            @else
                                <div class="bg-soft-danger p-3 rounded-lg mb-3">
                                    <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
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