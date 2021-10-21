<x-dynamic-component :component="$app->componentName">

	<!-- Hero Section -->
	@if($category)
		@if(!empty($category->image) && strlen($category->image) > 5 && Storage::disk('s3')->exists($category->image))
			<div class="space-top-3 d-flex justify-content-center align-items-center"
					style="min-height: 30rem;background-image: url('{{Storage::disk('s3')->url($category->image)}}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="text-center">
					<h1><span class="bg-dark px-3 py-2 rounded-lg text-warning">{{ $category->name }}</span></h1>
					@if($category->meta_description)
						<div class="bg-dark py-1 rounded-lg px-2">
							<h5 class="text-white mb-0">{{ $category->meta_description }}</h5>
						</div>
					@endif
				</div>
			</div>
		@else
			<div class="bg-dark space-top-3 d-flex justify-content-center align-items-center"
					style="min-height: 20rem;">
				<div class="text-center px-5 ">
					<h1><span class="bg-dark px-3 py-2 rounded-lg text-warning">{{ $category->name }}</span></h1>
					@if($category->meta_description)
						<div class="bg-dark rounded-lg px-2">
							<h5 class="text-white mb-0">{{ $category->meta_description }}</h5>
						</div>
					@endif
				</div>
			</div>
		@endif
	@endif
	<!-- End Hero Section -->

	<!-- Blogs Section -->
	<div class="container space-1">
		<div class="row justify-content-lg-between">
			<div class="col-lg-9">
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
				@if($posts->count() > 0)
					@foreach($posts as $post)
						@if($post->status != 0)
							<!-- Blog -->
							@if(!empty($post->image) && strlen($post->image) > 5 && Storage::disk('s3')->exists($post->image))
								<div class="mb-5 p-3 bg-white shadow rounded-lg">
										<div class="row">
												<div class="col-md-5 d-flex align-items-center">
													<a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route('Post.show', $post->slug) }}@endif">
														@php
																$path = explode("/", $post->image);
																$path = explode(".", $path[1]);
																$path = $path[0];
														@endphp
														@if(Storage::disk('s3')->exists('resized_images/'.$path.'_mobile.'.$ext))
																<img class="img-fluid rounded-lg rounded-3 mb-2 " src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}">
														@else
																<img class="img-fluid rounded-lg rounded-3 mb-2 " src="{{ Storage::disk('s3')->url($post->image) }}">
														@endif  
														</a>                      
												</div>
												<div class="col-md-7">
														<div class="card-body d-flex flex-column h-100 p-0">
																<h3><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route('Post.show', $post->slug) }}@endif">{{$post->title}}</a></h3>
																@if($post->excerpt)
																		<p>{{ substr($post->excerpt, 0, 200) }}...</p>
																@else
																		@php
																				$content = strip_tags($post->content);
																				$content = substr($content, 0 , 200);
																		@endphp
																		<p>{{ $content }}...</p>
																@endif
																<div class="mb-3">
																		@if($post->tags)
																		@foreach($post->tags as $tag)
																				<a href="{{ route('Tag.show', $tag->slug) }}" class="badge rounded-badge bg-soft-primary px-2 py-1">{{ $tag->name }}</a>
																		@endforeach
																		@endif
																</div>
																<div>
																		<a href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route('Post.show', $post->slug) }}@endif" class="btn btn-sm btn-primary">Continue Reading</a>
																</div>
														</div>
												</div>
										</div>
								</div>
							@else
								<div class="mb-5 p-3 bg-white shadow rounded-lg">
										<div class="card-body d-flex flex-column h-100 p-0">
												<h3><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route('Post.show', $post->slug) }}@endif">{{$post->title}}</a></h3>
												@if($post->excerpt)
														<p>{{ substr($post->excerpt, 0, 200) }}...</p>
												@else
														@php
																$content = strip_tags($post->content);
																$content = substr($content, 0 , 200);
														@endphp
														<p>{{ $content }}...</p>
												@endif
												<div class="mb-3">
														@if($post->tags)
														@foreach($post->tags as $tag)
																<a href="{{ route('Tag.show', $tag->slug) }}" class="badge rounded-badge bg-soft-primary px-2 py-1">{{ $tag->name }}</a>
														@endforeach
														@endif
												</div>
												<div>
														<a href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route('Post.show', $post->slug) }}@endif" class="btn btn-sm btn-primary">Continue Reading</a>
												</div>
										</div>
								</div>
							@endif
							<!-- End Blog -->
						@endif
					@endforeach
				@else
					<div class="text-center mb-5 p-3 bg-soft-danger rounded-lg">
						<h2 class="text-danger">No Posts to show</h2>
					</div>
				@endif
				
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

				<!-- Paginatin -->
				<div class="my-3 overflow-auto">
					{{ $posts->links() ?? "" }}
				</div>
				<!-- End Pagination -->
			</div>
			<!-- End Blog -->

			<!-- Right Section -->
			<div class="col-lg-3">
				<div class="mb-5">
					<!-- Search Form -->
					<form action="{{ route('Post.search') }}" method="GET">
						<div class="input-group mb-3"> 
							<input type="text" class="form-control input-text" placeholder="Search..." name="query">
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
					<div class="my-5">
						@foreach($settings->ads as $ad)
							@if($ad->position == 'sidebar-top')
								{!! $ad->content !!}
							@endif
						@endforeach
					</div>
				@endif
				<!-- End Ad Section -->

				<!---------Categories section-----> 
				@if(!empty($objs))
					<div class="mb-5">
						<h5 class="font-weight-bold mb-3">Categories</h5>
						<div class="list-group">
							@foreach($objs as $obj)
									@if($obj->posts->count() > 0)
											<a type="button" href="{{ route('Category.show', $obj->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" aria-current="true">
											{{ $obj->name }}<span class="badge bg-primary text-white rounded-pill">{{ $obj->posts->count() }}</span>
											</a>
									@endif
							@endforeach
						</div>
					</div>
				@endif
				<!--------- End categories section----->

				<!----- Tags section------>
				@if(!empty($tags))
					<div class="mb-5">
						<h5 class="font-weight-bold mb-3">Tags</h5>
						@foreach($tags as $kt=>$tag)
							<a class="btn btn-sm btn-outline-dark mb-1" href="{{ route('Tag.show', $tag->slug) }}">{{ $tag->name }}</a>
						 @if($kt==6)
                            @break
                        @endif  
						@endforeach
					</div>
				@endif
				<!----- End Tags Section------>

				@if(!empty($popular))
				<div class="mb-7">
					<div class="mb-3">
						<h3>Popular</h3>
					</div>

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
																				<img class="img-fluid rounded-lg rounded-3 mb-2 " src="{{ Storage::disk('s3')->url('resized_images/'.$path.'_mobile.'.$ext) }}">
																		@else
																				<img class="img-fluid rounded-lg rounded-3 mb-2 " src="{{ Storage::disk('s3')->url($post->image) }}">
																		@endif
																</div>
																<div class="col-8 pl-0">
																		<h6 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route('Post.show', $post->slug) }}@endif">{{ $post->title }}</a></h6>
																		<p class="text-muted m-0">{{ $post->created_at ? $post->created_at->diffForHumans() : "" }}</p>
																</div>
														</div>
												</div>
												<!-- End Related Post -->
										@endif
								@else
										<div class="bg-soft-danger p-3 rounded-lg mb-3">
												<h5 class="mb-0"><a class="text-decoration-none text-dark" href="@if(!empty($route)){{ $route.'/'.$post->slug }}@else{{ route('Post.show', $post->slug) }}@endif">{{ $post->title }}</a></h5>
												@if($post->excerpt)
														<p>{{ substr($post->excerpt, 0, 50) }}...</p>
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
				@endif

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
		</div>
		<!-- End of Row -->

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
	<!-- End Blogs Section -->

</x-dynamic-component>