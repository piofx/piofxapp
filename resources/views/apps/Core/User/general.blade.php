<x-dynamic-component :component="$app->componentName" class="mt-4" >
	<h1> hello <span class="text-success">{{$record->name}}</span></h1>
	<p>Welcome aboard!</p>

	<a href="/blog">View Our Blog</a> | <a href="/">Go to Homepage</a> | <a href="/logout">Logout</a>

</x-dynamic-component>