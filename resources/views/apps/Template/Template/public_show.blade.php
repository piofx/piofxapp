<x-dynamic-component :component="$app->componentName">

<div class="bg-soft-info py-5 space-top-3">
    <div class="container">
        <a href="{{ route('Template.public_index') }}" class="btn btn-sm btn-soft-danger"><i class="fas fa-reply"></i></a>
        <div class="mt-5 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="d-inline">{{$obj->name}}</h2>
                <h5 class="text-muted">{{$obj->slug}}</h5>
            </div>
            <div>
                <a href="{{ $obj->preview_path }}" target="_blank" class="btn btn-primary btn-sm">Preview</a>
                <a href="{{$obj->download_path}}" class="btn btn-dark btn-sm">Download</a>
            </div>
        </div>
    </div>
</div>


<div class="container my-5">
    <!----- Tags section------>
    <div class="mb-5 d-flex justify-content-center align-items-center">
        @foreach($obj->template_tags as $tag)
            <h3><a class="badge rounded-badge bg-soft-primary text-dark py-2 px-3 mb-2 ml-2" href="{{ route('Template.public_index', 'tag_id='.$tag->id.'') }}"
        {{ $tag->name}}">{{ $tag->name }}</a></h3>
        @endforeach
    </div>
    <!----- End Tags Section------>   

    <div class="row">
        @foreach($screen_shots as $name => $screen_shot)
            @if($name == "home" || $name == "Home")
                <div class="col-4">
                    <div class="card shadow-lg rounded-lg mb-5" style="width: 22rem;">
                        <a href="{{$screen_shot}}" data-lightbox="screens"><img class="card-img-top" src="{{$screen_shot}}"></a>
                        <div class="card-body">
                            <a class="card-title"><h3>{{$name}}</h3></a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="col-8">
            <div class="row">
                @foreach($screen_shots as $name => $screen_shot)
                    @if(!($name == "home" || $name == "Home"))
                        <div class="col-6">
                            <div class="card shadow-lg rounded-lg mb-5" style="width: 22rem;">
                                <a href="{{$screen_shot}}" data-lightbox="screens"><img class="card-img-top rounded-lg" src="{{$screen_shot}}"></a> 
                                <div class="card-body">
                                    <a class="card-title"><h3>{{ucwords($name)}}</h3></a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

</div>

</x-dynamic-component>