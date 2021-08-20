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
            <a href="#"  class="text-muted text-decoration-none">Normal Mode</a>
        </li>
    </ul>
    <!--end::Breadcrumb-->

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

                @if(!empty($settings))
                    <div class="bg-light p-7 mt-5 rounded-lg border">
                        @php
                            function isAssoc(array $array) {
                                return count(array_filter(array_keys($array), 'is_string')) > 0;
                            }
                            
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
                                @if (isAssoc($setting))
									<div class="my-5">
										<h2 class="font-weight-bold">{{ $k }}</h2>
										<div class="bg-white p-5 rounded-lg">
											@foreach($setting as $k => $v)
												<div class="row">
													<div class="col-12 col-lg-2 d-flex align-items-center mt-2 mb-0 mb-lg-2">
														<h5 class="m-0">{{ ucwords(str_replace('_', ' ', $k)) }}</h5>
													</div>
													<div class="col-12 col-lg-10 my-2">
														<input type="text" name="{{ 'settings-' . $k }}" class="form-control" value="{{ $v }}">
													</div>
												</div>
											@endforeach
										</div>
									</div>
								@else
                                    <div class="my-5">
										<h2 class="font-weight-bold mb-3">{{ ucwords(str_replace('_', ' ', $k)) }}</h2>
										<div class="bg-white p-5 rounded-lg">
											{{ print_data($setting, $k) }}
										</div>
									</div>
                                @endif
                            @else
                                @php
                                    $template = explode("_", $k);
                                @endphp
                                @if(strtolower($template[0]) == 'template')
                                    <div class="row my-5">
                                        <div class="col-12 p-0 px-lg-3 col-lg-2 d-flex align-items-center">
                                            <h5 class="m-0 mb-3 mb-lg-0">{{ ucwords(str_replace('_', ' ', $k)) }}</h5>
                                        </div>
                                        <div class="col-12 col-lg-10 p-0 px-lg-3">
                                            <textarea type="text" rows="20" name="{{ 'settings-' . $k }}" class="form-control">{{ stripslashes(json_decode($setting)) }}</textarea>
                                        </div>
                                    </div>
                                @else
                                    <div class="row my-5">
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