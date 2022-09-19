<x-dynamic-component :component="$app->componentName">  

    <!-- Check if browser supports webP format for images -->
    @php
        if( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {
            $ext = 'webp';
        }
        else{
            $ext = 'jpg';
        }
    @endphp

    <!-- Article Description Section -->
    <div class="container space-top-2">
        <!-- Breadcrumbs -->
        <nav class="my-1 pt-8 pt-lg-6">
            <ol class="breadcrumb m-0 p-0" style="background: transparent;">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/blog">Blog</a></li>
                <li class="breadcrumb-item d-none d-md-inline">{{ $obj->title }}</li>
            </ol>
        </nav>
        <!-- Breadcrumbs -->

        <!-- Ad -->
        @if(!empty($settings->ads))
            <div>
                @foreach($settings->ads as $ad)
                    @if($ad->position == 'before-body')
                        {!! $ad->content !!}
                    @endif
                @endforeach
            </div>
        @endif
        <!-- End Ad Section -->

        @if($settings->post_layout != 'full')
        <div class="row mt-3">
        @else
        <div class="mt-3">
        @endif
            @if($settings->post_layout == 'left')
                <div class="col-12 col-lg-3 d-none d-lg-block">
                    <!-- Ad -->
                    @if(!empty($settings->ads))
                        <div class="mb-5">
                            @foreach($settings->ads as $ad)
                                @if($ad->position == 'sidebar-top')
                                    {!! $ad->content !!}
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <!-- End Ad Section -->

                    <!-- Related Posts Left Section -->
                    @if(!empty($related) && sizeof($related) > 1)
                        <div class="mb-5">
                            <div class="mb-3">
                                <h3 class="font-weight-bold">@if($settings->language == 'telugu') సంబంధిత వార్తలు @else Related Posts @endif</h3>
                            </div>
                            @foreach($related as $post)
                                @if($post->id != $obj->id)
                                    @if(!empty($post->image) && strlen($post->image) > 5)
                                        @if(Storage::disk('s3')->exists($post->image))
                                            <!-- Related Post -->
                                            <div class="bg-soft-primary p-3 rounded-lg mb-3">
                                                <div class="row justify-content-between align-items-center">
                                                    <div class="col-4">
                                                        @php
                                                            $path = explode("/", $post->image);
                                                            $path = explode(".", $path[1]);
                                                            $path = $path[0];
                                                        @endphp
                                                        @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                                            <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                        @else
                                                            <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($post->image) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                        @endif
                                                    </div>
                                                    <div class="col-8 pl-0">
                                                        <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                                        <p class=" m-0">{{ $post->created_at ? $post->created_at->diffForHumans() : "" }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Related Post -->
                                        @endif
                                    @else
                                        <div class="bg-soft-primary p-3 rounded-lg mb-3">
                                            <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                            @if($post->excerpt)
                                                <p class="">{{ substr($post->excerpt, 0, 50) }}...</p>
                                            @else
                                                @php
                                                    $content = strip_tags($post->content);
                                                    $content = substr($content, 0 , 50);
                                                @endphp
                                                <p class="">{{ $content }}...</p>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <!-- End Related Posts Section -->

                    <!----- Tags section------>
                    @if(!isset($settings->tag)) 
                    @if(!empty($tags) && sizeof($tags) > 0)
                        <div class="mb-5">
                            <h3 class="font-weight-bold mb-3">@if($settings->language == 'telugu') టాగ్లు @else Tags @endif</h3>
                            @foreach($tags as $kt=>$tag)
                            <a class="btn btn-sm btn-outline-dark mb-1" href="{{ route('Tag.show', $tag->slug) }}">{{ $tag->name }}</a>
                                @if($kt==6)
                                    @break
                                @endif  
                            @endforeach
                        </div>
                    @endif
                    @endif
                    <!----- End Tags Section------>

                    <!-- Popular Posts -->
                    @if(!empty($popular) && sizeof($popular) > 0)
                        <div class="mb-5">
                            <h3 class="font-weight-bold mb-3">@if($settings->language == 'telugu') ముఖ్య విశేషాలు @else Popular Posts @endif</h3>
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
                                                            <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                        @else
                                                            <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($post->image) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                        @endif
                                                    </div>
                                                    <div class="col-8 pl-0">
                                                        <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                                        <p class=" m-0">{{ $post->created_at ? $post->created_at->diffForHumans() : "" }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Related Post -->
                                        @endif
                                    @else
                                        <div class="bg-soft-danger p-3 rounded-lg mb-3">
                                            <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                            @if($post->excerpt)
                                                <p class="">{!! substr($post->excerpt, 0, 50) !!}...</p>
                                            @else
                                                @php
                                                    $content = strip_tags($post->content);
                                                    $content = substr($content, 0 , 50);
                                                @endphp
                                                <p class="">{{ $content }}...</p>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <!-- End Popular Posts -->
                    <!-- Ad -->
                    @if(!empty($settings->ads))
                        <div class="mb-5">
                            @foreach($settings->ads as $ad)
                                @if($ad->position == 'sidebar-bottom')
                                    {!! $ad->content !!}
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <!-- End Ad Section -->
                </div>
            @endif
        
            <div  @if($settings->post_layout != 'full') class="col-12 col-lg-9" @endif>
                <div class="bg-white p-3 rounded rounded-3 rounded-lg mb-4">
                    <div class="mb-3">
                        @if(!empty($obj->top_head))
                            <h5 class="text-muted m-0">{{$obj->top_head}}</h5>
                        @endif
                        <div class="d-md-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h1 class="m-0">{{$obj->title}}</h1>
                                <div class="border-bottom border-3 border-primary rounded-lg rounded-3" style="width: 5rem"></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt mr-2" style="margin-bottom: 0.2rem;"></i>
                                {{ $obj->updated_at ? $obj->updated_at->format('M d Y') : '' }}
                            </div>
                            @if(!empty($postCategory->name) && strtolower($postCategory->name) != 'uncategorized')
                                <p class="m-0 mr-3 ml-3"> | </p>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('Category.show', $postCategory->slug) }}" class="text-decoration-none d-flex align-items-center"><span class="badge badge-secondary">{{ $postCategory->name }}</span></a>
                                </div>
                            @endif
                            @php
                                $allowed_roles = ['superadmin', 'agencyadmin', 'clientadmin','clientmoderator'];
                            @endphp
                            @if(!empty(auth()->user()) && in_array(auth()->user()->role, $allowed_roles))
                                <p class="m-0 mr-3 ml-3"> | </p>
                                <a href="{{ route($app->module.'.edit', $obj->slug) }}"><i class="fas fa-edit" style="margin-bottom: 0.1rem;"></i> Edit</a>
                            @endif
                        </div>

                        @if(!empty($obj->excerpt))
                        <div style="font-size: 1.2rem; line-height: 2rem;" >
                            <div class="blog_class">
                           <p class="mt-3"> {{ $obj->excerpt }}</p>
                       </div>
                        </div>
                        @endif

                    </div>

                    <!-- Author and share -->
                    @if(isset($settings->author_section ))
                    @if($settings->author_section && $settings->author_section == 'show')
                        <div class="border-top border-bottom mb-5">
                            <div class="row align-items-md-center">
                                <div class="col-7 p-0 pl-3">
                                    <div class="d-flex align-items-center py-1 justify-content-start">
                                        @if(!empty($author))
                                            @if($author->image)
                                                <div class="rounded-circle">
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
                                                <h4 class="bg-soft-primary text-primary m-0 px-4 py-3 rounded-circle">{{ strtoupper($author->name[0]) }}</h4>
                                            @endif
                                            <div class="pl-2 ps-2">
                                                <h5 class="m-0"><a href="{{ route($app->module.'.author', $author->id) }}">{{ $author->name}}</a></h5>
                                                <span class="d-block ">{{ $obj->created_at ? $obj->created_at->diffForHumans() : "" }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-5 p-0 pr-4">
                                    <div class="d-flex justify-content-md-end align-items-center">
                                        <!-- Facebook (url) -->
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="btn btn-xs btn-icon btn-soft-secondary rounded-circle ml-2 ms-2">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>

                                        <!-- Twitter (url, text, @mention) -->
                                        <a href="https://twitter.com/share?url={{ url()->current() }}&text={{ rawurlencode($obj->title) }}" target="_blank" class="btn btn-xs btn-icon btn-soft-secondary rounded-circle ml-2 ms-2">
                                            <i class="fab fa-twitter"></i>
                                        </a>

                                        <!-- Reddit (url, title) -->
                                        <a href="https://reddit.com/submit?url={{ url()->current() }}&title={{ rawurlencode($obj->title) }}" target="_blank" class="btn btn-xs btn-icon btn-soft-secondary rounded-circle ml-2 ms-2">
                                            <i class="fab fa-reddit"></i>
                                        </a>

                                        <!-- LinkedIn (url, title, summary, source url) -->
                                        <a href="https://www.linkedin.com/shareArticle?url={{ url()->current() }}&title={{ rawurlencode($obj->title) }}&summary={{ $obj->excerpt }}&source={{ url('/') }}" target="_blank" class="btn btn-xs btn-icon btn-soft-secondary rounded-circle ml-2 ms-2">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @endif
                    <!-- End Author and share -->

                    <!-- Featured Image -->
                    @if(!empty($obj->image) && strlen($obj->image) > 5)
                        @if(Storage::disk('s3')->exists($obj->image))
                            <div class="text-center mb-5">
                                @php
                                    $path = explode("/", $obj->image);
                                    $path = explode(".", $path[1]);
                                    $path = $path[0];
                                @endphp
                                @if(Browser::isMobile())
                                    @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                        <img class="img-fluid rounded-lg rounded-3 w-100" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}" alt="{{$obj->title}} - {{request()->get('client.name')}}">
                                    @else
                                        <img class="img-fluid rounded-lg rounded-3 w-100" src="{{ Storage::disk('s3')->url($obj->image) }}" alt="{{$obj->title}} - {{request()->get('client.name')}}">
                                    @endif
                                @else
                                    @if(Storage::disk('s3')->exists('resized_images/'.$path.'_resized.'.$ext))
                                        <img class="img-fluid rounded-lg rounded-3 w-100" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_resized.'.$ext) }}" alt="{{$obj->title}} - {{request()->get('client.name')}}">
                                    @else
                                        <img class="img-fluid rounded-lg rounded-3 w-100" src="{{ Storage::disk('s3')->url($obj->image) }}" alt="{{$obj->title}} - {{request()->get('client.name')}}">
                                    @endif
                                @endif
                            </div>
                        @endif
                    @endif
                    <!-- End Featured Image -->

                    <!-- Ad -->
                    @if(!empty($settings->ads))
                        <div class="mb-5">
                            @foreach($settings->ads as $ad)
                                @if($ad->position == 'before-content')
                                    {!! $ad->content !!}
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <!-- End Ad Section -->

                    @php
                        $dom = new \DomDocument();
                        libxml_use_internal_errors(true);
                        $dom->loadHtml(mb_convert_encoding($obj->content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
                        $images = $dom->getElementsByTagName('img');
                        $src = null;
                        $altContent = null;

                        $device = '_resized.';
                        if(Browser::isMobile()){
                            $device = '_mobile.';
                        }

                        foreach($images as $k => $img){
                            $src = $img->getAttribute('src');
                            $path = parse_url($src, PHP_URL_PATH);
                            $path = explode("/", $path);
                            $path = end($path);
                            $path = explode(".", $path);
                            $path = $path[0];
                            if(Storage::disk('s3')->exists('resized_images/'.$path. $device .$ext)){
                                $base = explode("/images", $src);
                                $url = $base[0] . '/resized_images/'.$path. $device .$ext;
                                $img->removeAttribute('src');
                                $img->setAttribute('src', $url);
                            }
                        }  

                        if($src){
                            $altContent = $dom->saveHTML();
                        }
                    @endphp

                    <div style="font-size: 1.2rem; line-height: 2rem;">
                        <div class="blog_class">
                        @if($obj->visibility == "private")
                            @if(auth()->user())
                                @php
                                    $user_group = explode(",", auth()->user()->group);
                                    $post_group = explode(",", $obj->group);
                                    $group = array_intersect($user_group, $post_group);
                                @endphp
                                @if(sizeOf($group) > 0)
                                    {!! $obj->content !!}
                                @else
                                    <div class="text-center bg-soft-danger p-3 rounded-lg">
                                        <h3 class="rounded-lg">Sorry but it seems that this post is currently locked</h3>
                                        <img src="{{ asset('img/locked.png') }}" class="img-fluid w-50">
                                    </div>
                                @endif
                            @else
                                <div class="text-center bg-soft-danger p-3 rounded-lg">
                                    <h3 class="rounded-lg">Sorry but it seems that this post is currently locked</h3>
                                    <img src="{{ asset('img/locked.png') }}" class="img-fluid w-50">
                                </div>
                            @endif
                        @else
                            @if(!empty($altContent))
                                {!! $altContent !!}
                            @else
                                {!! $obj->content !!}
                            @endif
                        @endif
                    </div>
                    </div>

                    <!-- Link -->
                    @if($obj->link)
                        @auth
                        <div class="btn btn-primary mb-4 click_link"  data-href="{{$obj->link}}" data-user_id="{{Auth::user()->id}}" data-client_id="{{request('client.id')}}" data-agency_id="{{request()->get('agency.id')}}">{{$obj->link_title}}</div>
                        @else
                        <a href="#" class="btn btn-primary mb-4" data-toggle="modal" data-target="#loginModal">{{$obj->link_title}}</a>
                        
                        @endauth
                    @endif
                    <!-- end link-->

                    <!-- Tags -->
                    @if(!empty($postTags) && sizeof($postTags) > 0)
                        <div class="mt-5">
                            <h4>Tags</h4>
                            @foreach($postTags as $tag)
                                <a class="btn btn-sm btn-soft-dark py-1 px-2 mr-1 mb-2" href="{{ route('Tag.show', $tag->slug) }}">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    @endif
                    <!-- End Tags -->

                    <!-- Share -->
                    <div class="d-flex justify-content-sm-between align-items-sm-center mt-3 mb-5">
                        <div class="d-flex align-items-center">
                            <small class=" font-weight-bold">SHARE:</small>

                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="btn btn-xs btn-icon btn-ghost-secondary rounded-circle ml-2 ms-2">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/share?url={{ url()->current() }}&text={{ rawurlencode($obj->title) }}" target="_blank" class="btn btn-xs btn-icon btn-ghost-secondary rounded-circle ml-2 ms-2">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://reddit.com/submit?url={{ url()->current() }}&title={{ rawurlencode($obj->title) }}" target="_blank" class="btn btn-xs btn-icon btn-ghost-secondary rounded-circle ml-2 ms-2">
                                <i class="fab fa-reddit"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?url={{ url()->current() }}&title={{ rawurlencode($obj->title) }}&summary={{ $obj->excerpt }}&source={{ url('/') }}" target="_blank" class="btn btn-xs btn-icon btn-ghost-secondary rounded-circle ml-2 ms-2">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                    <!-- End Share -->

                    <!-- Ad -->
                    @if(!empty($settings->ads))
                        <div class="mb-5">
                            @foreach($settings->ads as $ad)
                                @if($ad->position == 'after-content')
                                    {!! $ad->content !!}
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <!-- End Ad Section -->
                </div>


                <!-- Newsletter -->
                <!-- @if(Auth::user())
                    <div class="bg-soft-danger p-5 rounded-lg rounded-3">
                        <div class="mb-3">
                            <h2 class="m-0">Liked what you have read?</h2>
                            <h5 class="">Subscribe to our Newsletter</h5>
                        </div>
                        <form action="{{route($app->module.'.subscribe')}}" enctype="multipart/form-data" method="POST">
                            <button class="btn btn-danger btn-sm">Subscribe</button>
                            
                            <input type="text" name="name" placeholder="Name" class="form-control mb-2 @if(Auth::user()) d-none @endif" value="@if(Auth::user()) {{Auth::user()->name}} @endif">
                            <input type="email" name="email" placeholder="Email" class="form-control mb-2  @if(Auth::user()) d-none @endif" value="@if(Auth::user()) {{Auth::user()->email}} @endif">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                @else
                    <div class="bg-soft-danger p-5 rounded-lg rounded-3">
                        <div class="row">
                            <div class="col-12 col-lg-6 d-lg-flex align-items-center justify-content-center">
                                <div class="mb-3">
                                    <h2 class="m-0">Liked what you have read?</h2>
                                    <h5 class="">Subscribe to our Newsletter</h5>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 d-lg-flex align-items-center justify-content-center">
                                <form action="{{route($app->module.'.subscribe')}}" enctype="multipart/form-data" method="POST">                                
                                    <input type="text" name="name" placeholder="Name" class="form-control mb-2 @if(Auth::user()) d-none @endif" value="@if(Auth::user()) {{Auth::user()->name}} @endif">
                                    <input type="email" name="email" placeholder="Email" class="form-control mb-2  @if(Auth::user()) d-none @endif" value="@if(Auth::user()) {{Auth::user()->email}} @endif">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button class="btn btn-danger btn-sm">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif -->
                <!-- End Newsletter -->

                <!-- Related Posts Full Section -->
                @if($settings->post_layout == 'full')
                    @if(!empty($related)  && sizeof($related) > 1)
                        <div class="my-5 d-none d-lg-block">
                            <div class="mb-3">
                                <h3 class="font-weight-bold">@if($settings->language == 'telugu') సంబంధిత వార్తలు @else Related Posts @endif</h3>
                            </div>
                            <div class="row">
                                @foreach($related as $post)
                                    @if($post->id != $obj->id)
                                        @if(!empty($post->image) && strlen($post->image) > 5)
                                            @if(Storage::disk('s3')->exists($post->image))
                                                <div class="col-4 mb-3">
                                                    <div class="bg-soft-primary p-3 rounded-lg d-flex align-items-center" style="min-height: 9.3rem;">
                                                        <!-- Related Post -->
                                                        <div class="row justify-content-between align-items-center">
                                                            <div class="col-4">
                                                                @php
                                                                    $path = explode("/", $post->image);
                                                                    $path = explode(".", $path[1]);
                                                                    $path = $path[0];
                                                                @endphp
                                                                @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                                                    <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                                @else
                                                                    <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($post->image) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                                @endif
                                                            </div>
                                                            <div class="col-8 pl-0">
                                                                <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                                                <p class=" m-0">{{ $post->created_at ? $post->created_at->diffForHumans() : "" }}</p>
                                                            </div>
                                                        </div>
                                                        <!-- End Related Post -->
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="col-4 mb-3">
                                                <!-- Related Post -->
                                                <div class="bg-soft-primary p-3 rounded-lg d-flex align-items-center" style="min-height: 9.3rem;">
                                                    <div>
                                                        <h5 class="mb-0"><a class="text-decoration-none text-dark" href="">{{ $post->title }}</a></h5>
                                                        @if($post->excerpt)
                                                            <p class="">{{ substr($post->excerpt, 0, 50) }}...</p>
                                                        @else
                                                            @php
                                                                $content = strip_tags($post->content);
                                                                $content = substr($content, 0 , 50);
                                                            @endphp
                                                            <p class="">{{ $content }}...</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- End Related Post -->
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        
                        </div>
                    @endif
                @endif
                <!-- End Related Posts Section -->
            </div>

            <div class="d-lg-none px-3">
                <!-- Related Posts Right Section -->
                @if(!empty($related) && sizeof($related) > 1)
                    <div class="mb-5">
                        <h3 class="font-weight-bold mb-3">@if($settings->language == 'telugu') సంబంధిత వార్తలు @else Related Posts @endif</h3>
                        @foreach($related as $post)
                            @if($post->id != $obj->id)
                                @if(!empty($post->image) && strlen($post->image) > 5)
                                    @if(Storage::disk('s3')->exists($post->image))
                                        <!-- Related Post -->
                                        <div class="bg-soft-primary p-3 rounded-lg mb-3">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-4">
                                                    @php
                                                        $path = explode("/", $post->image);
                                                        $path = explode(".", $path[1]);
                                                        $path = $path[0];
                                                    @endphp
                                                    @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                                        <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}" alt="{{$obj->title}} - {{request()->get('client.name')}}">
                                                    @else
                                                        <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($post->image) }}" alt="{{$obj->title}} - {{request()->get('client.name')}}">
                                                    @endif
                                                </div>
                                                <div class="col-8 pl-0">
                                                    <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                                    <p class=" m-0">{{ $post->created_at ? $post->created_at->diffForHumans() : "" }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Related Post -->
                                    @endif
                                @else
                                    <div class="bg-soft-primary p-3 rounded-lg mb-3">
                                        <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                        @if($post->excerpt)
                                            <p class="">{{ substr($post->excerpt, 0, 50) }}...</p>
                                        @else
                                            @php
                                                $content = strip_tags($post->content);
                                                $content = substr($content, 0 , 50);
                                            @endphp
                                            <p class="">{{ $content }}...</p>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endif
                <!-- End Related Posts Section -->

                <!----- Tags section------>
                @if(!isset($settings->tag)) 
                @if(!empty($tags) && sizeof($tags) > 0)
                    <div class="mb-5">
                        <h3 class="font-weight-bold mb-3">@if($settings->language == 'telugu') టాగ్లు @else Tags @endif</h3>
                        @foreach($tags as $tag)
                        <a class="btn btn-sm btn-soft-dark py-1 px-2 mr-1 mb-2" href="{{ route('Tag.show', $tag->slug) }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                @endif
                @endif

                <!----- End Tags Section------>

                <!-- Popular Posts -->
                @if(!empty($popular) && sizeof($popular) > 0)
                    <div class="mb-5">
                        <h3 class="font-weight-bold mb-3">@if($settings->language == 'telugu') ముఖ్య విశేషాలు @else Popular Posts @endif</h3>
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
                                                        <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                    @else
                                                        <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($post->image) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                    @endif
                                                </div>
                                                <div class="col-8 pl-0">
                                                    <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                                    <p class=" m-0">{{ $post->created_at ? $post->created_at->diffForHumans() : "" }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Related Post -->
                                    @endif
                                @else
                                    <div class="bg-soft-danger p-3 rounded-lg mb-3">
                                        <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                        @if($post->excerpt)
                                            <p class="">{!! substr($post->excerpt, 0, 50) !!}...</p>
                                        @else
                                            @php
                                                $content = strip_tags($post->content);
                                                $content = substr($content, 0 , 50);
                                            @endphp
                                            <p class="">{{ $content }}...</p>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endif
                <!-- End Popular Posts --> 
            </div>

            @if($settings->post_layout == 'right')
            <div class="col-12 col-lg-3 d-none d-lg-block">

                <!-- login -->
                @include('apps.Blog.Post.homeLayouts.login')
                <!-- end login -->

                <!-- Ad -->
                @if(!empty($settings->ads))
                    <div class="mb-5">
                        @foreach($settings->ads as $ad)
                            @if($ad->position == 'sidebar-top')
                                {!! $ad->content !!}
                            @endif
                        @endforeach
                    </div>
                @endif
                <!-- End Ad Section -->

                <!-- Related Posts Right Section -->
                @if(!empty($related) && sizeof($related) > 1)
                    <div class="mb-5">
                        <div class="mb-3">
                            <h3 class="font-weight-bold">@if($settings->language == 'telugu') సంబంధిత వార్తలు @else Related Posts @endif</h3>
                        </div>
                        @foreach($related as $post)
                            @if($post->id != $obj->id)
                                @if(!empty($post->image) && strlen($post->image) > 5)
                                    @if(Storage::disk('s3')->exists($post->image))
                                        <!-- Related Post -->
                                        <div class="bg-soft-primary p-3 rounded-lg mb-3">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-4">
                                                    @php
                                                        $path = explode("/", $post->image);
                                                        $path = explode(".", $path[1]);
                                                        $path = $path[0];
                                                    @endphp
                                                    @if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
                                                        <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                    @else
                                                        <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($post->image) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                    @endif
                                                </div>
                                                <div class="col-8 pl-0">
                                                    <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                                    <p class=" m-0">{{ $post->created_at ? $post->created_at->diffForHumans() : "" }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Related Post -->
                                    @endif
                                @else
                                    <div class="bg-soft-primary p-3 rounded-lg mb-3">
                                        <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                        @if($post->excerpt)
                                            <p class="">{{ substr($post->excerpt, 0, 50) }}...</p>
                                        @else
                                            @php
                                                $content = strip_tags($post->content);
                                                $content = substr($content, 0 , 50);
                                            @endphp
                                            <p class="">{{ $content }}...</p>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endif
                <!-- End Related Posts Section -->

                <!----- Tags section------>
                @if(!isset($settings->tag)) 
                @if(!empty($tags) && sizeof($tags) > 0)
                    <div class="mb-5">
                        <h3 class="font-weight-bold mb-3">@if($settings->language == 'telugu') టాగ్లు @else Tags @endif</h3>
                        @foreach($tags as $kt=>$tag)
                        <a class="btn btn-sm btn-soft-dark py-1 px-2 mr-1 mb-2" href="{{ route('Tag.show', $tag->slug) }}">{{ $tag->name }}</a>
                            @if($kt==6)
                                @break
                            @endif  
                        @endforeach
                    </div>
                @endif
                @endif
                <!----- End Tags Section------>

                <!-- Popular Posts -->
                @if(!empty($popular) && sizeof($popular) > 0)
                    <div class="mb-5">
                        <h3 class="font-weight-bold mb-3">@if($settings->language == 'telugu') ముఖ్య విశేషాలు @else Popular Posts @endif</h3>
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
                                                        <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                    @else
                                                        <img class="img-fluid rounded-lg rounded-3" src="{{ Storage::disk('s3')->url($post->image) }}" alt="{{$post->title}} - {{request()->get('client.name')}}">
                                                    @endif
                                                </div>
                                                <div class="col-8 pl-0">
                                                    <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                                    <p class=" m-0">{{ $post->created_at ? $post->created_at->diffForHumans() : "" }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Related Post -->
                                    @endif
                                @else
                                    <div class="bg-soft-danger p-3 rounded-lg mb-3">
                                        <h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route($app->module.'.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
                                        @if($post->excerpt)
                                            <p class="">{!! substr($post->excerpt, 0, 50) !!}...</p>
                                        @else
                                            @php
                                                $content = strip_tags($post->content);
                                                $content = substr($content, 0 , 50);
                                            @endphp
                                            <p class="">{{ $content }}...</p>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endif
                <!-- End Popular Posts -->
                <!-- Ad -->
                @if(!empty($settings->ads))
                    <div class="mb-3">
                        @foreach($settings->ads as $ad)
                            @if($ad->position == 'sidebar-bottom')
                                {!! $ad->content !!}
                            @endif
                        @endforeach
                    </div>
                @endif
                <!-- End Ad Section -->
            </div>
            @endif
        </div>

        <!-- Ad -->
        @if(!empty($settings->ads))
            <div class="my-3">
                @foreach($settings->ads as $ad)
                    @if($ad->position == 'after-body')
                        {!! $ad->content !!}
                    @endif
                @endforeach
            </div>
        @endif
        <!-- End Ad Section -->
    </div>
    <!-- End Article Description Section -->

     <!-- login modal -->
    @include('apps.Blog.Post.homeLayouts.loginModal')
     <!-- end login modal-->

    
</x-dynamic-component>