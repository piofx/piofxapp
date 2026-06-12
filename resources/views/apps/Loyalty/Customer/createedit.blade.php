<x-dynamic-component :component="$app->componentName">

    @if($alert ?? "")
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ $alert }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="p-5 mt-5 bg-white rounded shadow">
        <h1 class="text-center"></h1>
        @if($stub == 'create')
            <form action="{{ route($app->module.'.store') }}" method="POST" enctype="multipart/form-data">
        @else
            <form action="{{ route($app->module.'.update', $obj->id) }}" method="POST" enctype="multipart/form-data">
        @endif
                <label >Name:</label>
                <input type="text" class="form-control mt-1" name="name" value="{{ old('name') }} @if($stub == 'update'){{ $obj->name }}@endif">
                <label class="mt-3">Phone:</label>
                <div class="input-group">
                    <div class="input-group-text">+91</div>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }} @if($stub == 'update'){{ $obj->phone }}@endif">
                </div>
                <label class="mt-3">Email:</label>
                <input type="email" class="form-control mt-1" name="email" value="{{ old('email') }} @if($stub == 'update'){{ $obj->email }}@endif">
                <label class="mt-3">Address:</label>
                <textarea type="text" class="form-control mt-1" name="address">{{ old('address') }} @if($stub == 'update'){{ $obj->address }}@endif</textarea>
                @if($stub=='update')
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{ $obj->id }}">
                @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" hidden value="{{ url()->full() }}" name="current_url">
                    <input type="text" hidden value="{{ Auth::user()->id }}" name="user_id">
                    <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
                    <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
                    <button type="submit" class="btn btn-outline-dark mt-3" name="publish" value="now">Create</button>
            </form>
    </div>
</x-dynamic-component>