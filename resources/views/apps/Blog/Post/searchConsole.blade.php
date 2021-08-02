<x-dynamic-component :component="$app->componentName"> 

    <div class="row">
        <div class="col-6">
            @foreach($queryData as $k=>$v)
                <p class="d-block">{{print_r($v)}}</p>
            @endforeach
        </div>
        <div class="col-6">
            @foreach($pageData as $k=>$v)
                <p class="d-block">{{print_r($v)}}</p>
            @endforeach
        </div>
    </div>

</x-dynamic-component>