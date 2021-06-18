<x-dynamic-component :component="$app->componentName">

    <form action="{{ route($app->module.'.update') }}" method="POST">
        <div class="card rounded">
            <div class="card-body">
                <div class="p-5 rounded-lg border bg-light d-flex justify-content-between align-items-center">
                    <h1 class="m-0">Settings</h1>
                    <button type="submit" class="btn btn-dark">Update</button>
                </div>
                <div class="mt-5">
                    <div id="content" style="min-height: 800px"></div>
                    <textarea id="content_editor" class="form-control border d-none" name="settings" rows="5">@if(isset($stub) && $stub == 'update'){{$settings ? $settings : ''}}@endif</textarea>
                </div>
            </div>
        </div>
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="mode" value="dev">
    </form>

</x-dynamic-component>