<x-dynamic-component :component="$app->componentName">

<div class="space-top-2" style="background-color: #e6f2ff;">
    <div class="container space-2 mt-4 pb-5">
        <a href="{{ route('Template.public_index') }}" class="text-dark"><h2 class="d-inline">Template Library</h2></a>
        @if($category ?? "")
        <h2 class="d-inline"> > <span class="text-muted">{{ $category->name }}</span></h2>
        @endif
    </div>
</div>

<div class="container mt-5">
    <!-- Search Form -->
    <form action="{{ route($app->module.'.search') }}" method="GET">
        <div class="input-group mb-3 shadow"> 
        <input type="text" class="form-control input-text" placeholder="Search..." name="query">
        <div class="input-group-append">
            <button class="btn btn-outline-primary btn-md" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
        </div>
    </form>
    <!-- End Search Form --> 
</div>

<div class="container mt-3">
    <div class="row">
        <div class="col-12 col-lg-3 mt-5">
            <div class="bg-soft-primary p-5 rounded mb-5">
                <h4 class="text-secondary">❤️ Search and pick your favourite template from our templates library</h4>
            </div> 
            
            <!---------Categories section-----> 
            <div class="mb-5">
                <h5 class="font-weight-bold mb-3">Categories</h5>
                <div class="list-group shadow">
                @foreach($categories as $category)
                    <a type="button" href="{{ route('Template.public_index', 'category_id='.$category->id.'') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-soft-info border-info" aria-current="true">
                    {{ $category->name }}<span class="badge bg-primary text-white rounded-pill">{{ $category->templates->count() }}</span>
                    </a>
                @endforeach
                </div>
            </div>
            <!--------- End categories section----->

            <!----- Tags section------>
            <div class="mb-5">
                <h5 class="font-weight-bold mb-3">Tags</h5>
                @foreach($tags as $tag)
                    <a class="btn btn-sm btn-outline-dark mb-1" href="{{ route('Template.public_index', 'tag_id='.$tag->id.'') }}">{{ $tag->name }}</a>
                @endforeach
            </div>
            <!----- End Tags Section------>       
        </div>
        <div class="col-12 col-lg-9 mt-5">
            <h3 class="mb-4">Showing {{ $objs->count() }} Templates</h3>
            <div class="row">
                @foreach($objs as $obj)
                    <div class="col-12 col-lg-6 mb-5">
                        <div class="card shadow-lg rounded-lg" style="max-width: 24rem;">
                            <img class="card-img-top" src="{{$obj->index_screenshot}}" alt="Card image cap">
                            <div class="card-body">
                                <a class="card-title" href="{{ route('Template.public_show', $obj->slug) }}"><h3>{{$obj->name}}</h3></a>
                                <!-- Template Tags -->
                                @foreach($obj->template_tags as $tag)
                                    <a href="{{ route('Template.public_index', 'tag_id='.$tag->id.'') }}" class="badge rounded-badge bg-soft-danger text-dark py-2 px-3 mr-1 mb-3">{{ $tag->name }}</a>
                                @endforeach
                                <div class="row">
                                    <div class="col-6 pr-1">
                                        <a href="{{ route('Template.public_show', $obj->slug) }}" class="btn btn-block btn-sm btn-dark" >View Template</a>
                                    </div>
                                    <div class="col-6 pl-1">
                                        <a href="{{ $obj->preview_path }}" class="btn btn-block btn-sm btn-soft-dark" >Preview Template</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="mb-3">
                    {{ $objs->appends(["category_id" => request()->get('category_id'), "tag_id" => request()->get('tag_id')])->links() ?? "" }}
                </div>
            </div>
            @if($objs->count() == 0)
                <div class="d-flex justify-content-center bg-soft-danger rounded-lg p-3">
                    <h3 class="text-danger">No relevant templates to show</h3>
                </div>
            @endif
        </div>
    </div>
</div>

</x-dynamic-component>