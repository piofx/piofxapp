<x-dynamic-component :component="$app->componentName" class="mt-4" >
	
	{!! $obj->html_minified !!}

	@if(!$obj->auth)
		@include('apps.Blog.Post.homeLayouts.loginModal')
	@endif

</x-dynamic-component>