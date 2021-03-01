<x-dynamic-component :component="$app->componentName" class="mt-4" >
	<div class="page_wrapper">
		<div class="page_container">
			{!! $obj->html_minified !!}
		</div>
	</div>
</x-dynamic-component>