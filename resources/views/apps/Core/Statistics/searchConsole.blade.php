<x-dynamic-component :component="$app->componentName"> 

    @if(!$authentication)
        <div class="container bg-white p-5 rounded rounded-3">
            <form action="{{ route('Statistics.index') }}" method="GET">
                <label>Client Id</label>
                <input type="text" required name="client_id" class="form-control" placeholder="Ex: *****.apps.googleusercontent.com">
                <label class="mt-3">Client Secret</label>
                <input type="text" required name="client_secret" class="form-control">
                <div class="bg-light p-5 rounded rounded-3 mt-3">
                    <h5>Place this url in the allowed redirects</h5>
                    <input name="redirect_url" readonly id="redirect_url" class="form-control">
                </div>
                <button type="submit" class="btn btn-dark mt-3">Continue</button>

                <input type="hidden" id="website_url" name="website_url">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    @else
        @if(!empty($searchConsoleData))
            @foreach($searchConsoleData as $key=>$value)
                @if($key == '1Month')
                    @foreach($value as $data)
                        @foreach($data as $d)
                            {{ print_r($d['keys'][0]) }}
                            <br>
                        @endforeach
                    @endforeach
                @endif
            @endforeach
        @endif

    @endif

    <!-- Script to copy to clipboard -->
    <script>
        // Set the current url to redirect url
        document.getElementById('redirect_url').value = document.URL;
        // Get the root url
        // let website_url = window.location.protocol + "//" + window.location.host;
        let website_url = 'https://packetprep.com'
        document.getElementById('website_url').value = website_url;
        function copyToClipboard(){
            let text = document.getElementById("redirect_url");
        }
    </script>
    
</x-dynamic-component>