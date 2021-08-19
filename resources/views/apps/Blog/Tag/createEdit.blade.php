<x-dynamic-component :component="$app->componentName">
<!--begin::Breadcrumb-->
<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
    <li class="breadcrumb-item">
        <a href="/admin" class="text-muted text-decoration-none">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="/admin/blog"  class="text-muted text-decoration-none">{{ ucfirst($app->app) }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="/admin/blog/tags"  class="text-muted text-decoration-none">{{ ucfirst($app->module) }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="#"  class="text-muted text-decoration-none">Create/Edit</a>
    </li>
</ul>
<!--end::Breadcrumb-->
<div class="container my-5 p-5 rounded-lg bg-white shadow-sm">
    @if($stub == "create")
    <form method="POST" action="{{ route($app->module.'.store') }}">
    @else
    <form method="POST" action="{{ route($app->module.'.update', $obj->id) }}">
    @endif
      @csrf
      <h2 class="text-center font-weight-bolder text-primary py-2">Create a Tag</h3>
      <div class="my-3">
        <h5>Name:</h5>
        <input class="form-control" name="name" id="title" onkeyup="createSlug()" type="text" value="@if($stub == 'update'){{ $obj ? $obj->name : '' }}@endif">
        <h5 class="mt-3">Slug:</h5>
        <input class="form-control" name="slug" id="slug" type="text" value="@if($stub == 'update'){{ $obj ? $obj->slug : '' }}@endif">
        @if($stub=='update')
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="{{ $obj->id }}">
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        @else
            <button type="submit" class="btn btn-primary mt-3">Create</button>
        @endif
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
    </form>
</div>
</x-dynamic-component>