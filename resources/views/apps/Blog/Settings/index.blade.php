<x-dynamic-component :component="$app->componentName">

    <div class="card rounded">
        <div class="card-body">
            <form action="{{ route($app->module.'.update') }}" method="POST">
                <div class="p-5 rounded-lg border bg-light d-flex justify-content-between align-items-center">
                    <h1 class="m-0">Settings</h1>
                    <div>
                        <button  type="submit" class="btn btn-primary font-weight-bold">Save</button>
                        <a href="{{ route($app->module.'.edit') }}" class="btn btn-light-dark">Developer Mode</a>
                    </div>
                </div>
                <!-- <pre class="bg-light p-7 mt-5 rounded-lg border"><code json class="bg-light text-dark h4"></code></pre> -->

                @if(!empty($settings))
                    <div class="bg-light p-7 mt-5 rounded-lg border">
                        @php
                            function print_data($setting_array, $key){
                                $id = 0;
                                foreach($setting_array as $t => $data){
                                    $text = '<div class="bg-light rounded-lg p-3 px-5 mb-3">';
                                    foreach($data as $k => $s){
                                        $text = $text . '<div class="row my-3">
                                                            <div class="col-12 col-lg-2 p-2 px-lg-3 d-flex align-items-center">
                                                                <h5 class="m-0 mb-1 mb-lg-0">'. ucwords(str_replace('_', ' ', $k)) .'</h5>
                                                            </div>
                                                            <div class="col-12 col-lg-10 p-1 px-lg-3">
                                                                <input type="text" hidden name="settings-array-'. $key. '-' .$t .'-key[]" class="form-control" value="'. $k .'">
                                                                <input type="text" name="settings-array-'. $key. '-' .$t .'-value[]" class="form-control" value="'. $s .'">
                                                            </div>
                                                        </div>';
                                    }
                                    $text = $text . "</div>";
                                    echo $text;
                                    $id = $id + 1;
                                }
                            }
                        @endphp
                        @foreach($settings as $k => $setting)
                            @if(is_array($setting))
                                <div class="bg-white p-5 rounded-lg my-3">
                                    <h2 class="font-weight-bold mb-3 pl-2">{{ ucwords(str_replace('_', ' ', $k)) }}</h2>
                                    {{ print_data($setting, $k) }}
                                </div>
                            @else
                                @php
                                    $template = explode("_", $k);
                                @endphp
                                @if(strtolower($template[0]) == 'template')
                                    <div class="row mb-3">
                                        <div class="col-12 p-0 px-lg-3 col-lg-2 d-flex align-items-center">
                                            <h5 class="m-0 mb-3 mb-lg-0">{{ ucwords(str_replace('_', ' ', $k)) }}</h5>
                                        </div>
                                        <div class="col-12 col-lg-10 p-0 px-lg-3">
                                            <textarea type="text" name="{{ 'settings-' . $k }}" class="form-control">{{ stripslashes($setting) }}</textarea>
                                        </div>
                                    </div>
                                @else
                                    <div class="row mb-3">
                                        <div class="col-12 p-0 px-lg-3 col-lg-2 d-flex align-items-center">
                                            <h5 class="m-0 mb-3 mb-lg-0">{{ ucwords(str_replace('_', ' ', $k)) }}</h5>
                                        </div>
                                        <div class="col-12 col-lg-10 p-0 px-lg-3">
                                            <input type="text" name="{{ 'settings-' . $k }}" class="form-control" value="{{ $setting }}">
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endif

                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="mode" value="normal">
            </form>

        </div>
    </div>

</x-dynamic-component>