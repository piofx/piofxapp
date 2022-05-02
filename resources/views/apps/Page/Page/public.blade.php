<x-dynamic-component :component="$app->componentName" class="mt-4" >
	
	{!! $obj->html_minified !!}

	@if($obj->auth==1)
		@include('apps.Blog.Post.homeLayouts.loginModal')
	@elseif($obj->auth==2)
		@include('apps.Blog.Post.homeLayouts.registerModal')
	@endif

</x-dynamic-component>