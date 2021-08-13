<x-dynamic-component :component="$app->componentName">
  <!-- Validation Errors -->
  <x-auth-validation-errors class="mb-4" :errors="$errors" />
  <div class="container my-5 p-5 rounded-lg bg-white shadow-sm">
    @if($stub == "create")
    <form method="POST" action="{{ route($app->module.'.store') }}">
    @else
    <form method="POST" action="{{ route($app->module.'.update', $obj->id) }}">
    @endif
      @csrf
      <h3 class="text-center font-weight-bold py-2">Create a Tag</h3>
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