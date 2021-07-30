<x-dynamic-component :component="$app->componentName"> 


    <div class="container">

        <div class="bg-white rounded p-3">
            <h3>Open the link in a new tab</h3>
            <textarea readonly rows="3" class="form-control">{{ $authUrl }}</textarea>
        </div>   

        <div class="bg-white mt-5 rounded p-5">
            <h3>Paste the Code</h3>
            <form action="{{ route('Post.searchConsole') }}" method="POST">
                <input type="text" name="accessCode" class="form-control">
                <button type="submit" class="btn btn-primary mt-3">Add</button>

                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>

    </div>

</x-dynamic-component>