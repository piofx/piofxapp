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
            <a href="/admin/blog/settings"  class="text-muted text-decoration-none">{{ ucfirst($app->module) }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#"  class="text-muted text-decoration-none">Developer Mode</a>
        </li>
    </ul>
    <!--end::Breadcrumb-->
    <!--begin::Alert-->
    @if($alert)
        <x-snippets.alerts.basic>{{$alert}}</x-snippets.alerts.basic>
    @endif
    <!--end::Alert-->

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