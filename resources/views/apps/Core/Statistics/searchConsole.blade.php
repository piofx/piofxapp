<x-dynamic-component :component="$app->componentName"> 
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
        <li class="breadcrumb-item">
            <a href="/admin" class="text-muted text-decoration-none">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/admin"  class="text-muted text-decoration-none">{{ ucfirst($app->app) }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#"  class="text-muted text-decoration-none">{{ ucfirst($app->module) }}</a>
        </li>
    </ul>
    <!--end::Breadcrumb-->
    @if(!$authentication)
        <div class="container bg-white p-5 rounded rounded-3">
            <form action="{{ route('Statistics.index') }}" method="GET">
                <label>Client Id</label>
                <input type="text" required name="client_id" class="form-control" placeholder="Ex: *****.apps.googleusercontent.com">
                <label class="mt-3">Client Secret</label>
                <input type="text" required name="client_secret" class="form-control">
                <label class="mt-3">Website Url</label>
                <input type="text" class="form-control" id="website_url" name="website_url">
                <div class="bg-light p-5 rounded rounded-3 mt-3">
                    <h5>Place this url in the allowed redirects</h5>
                    <input name="redirect_url" readonly id="redirect_url" class="form-control">
                </div>
                <button type="submit" class="btn btn-dark mt-3">Continue</button>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    @else
        <div class="bg-white rounded p-5 my-5 d-flex aling-items-center justify-content-between">
            <div class="d-flex align-items-center justify-content-start">
                <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Media/Equalizer.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"/>
                        <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"/>
                        <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"/>
                        <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"/>
                    </g>
                </svg><!--end::Svg Icon--></span>
                <h1 class="m-0 ml-1">Statistics</h1>
            </div>
            <a href="{{ route('Statistics.index', 'statisticsRefresh=true') }}" class="btn btn-dark"><i class="fas fa-sync-alt"></i> Refresh</a>
        </div>
        <div class="bg-white rounded" style="padding: 2rem;">
            <h3 class="text-primary mb-5">Overview</h3>
            
            <form id="selectorForm" class="mb-5" action="{{ route('Statistics.index') }}" method="GET">
                <small class="ml-1 text-muted">Change this to change the data in the page</small>
                <select name="selector" id="selector" class="custom-select shadow-sm border-0" onchange="this.form.submit()">
                    <option value="1Month" {{ $selector == '1Month' ? 'selected' : null }}>1 Month</option>
                    <option value="3Months" {{ $selector == '3Months' ? 'selected' : null }}>3 Months</option>
                    <option value="1Year" {{ $selector == '1Year' ? 'selected' : null }}>1 Year</option>
                </select>
            </form>

            @if(!empty($fullData))
                <div class="d-lg-flex align-items-center justify-content-start my-3">
                    <div class="bg-white rounded shadow-sm p-5">
                        <h6 class="text-danger mb-3">Total Clicks</h6>
                        <h1 class="display-3">{{ $fullData['total_clicks'] }}</h1>
                    </div>
                    <div class="bg-white rounded shadow-sm p-5 ml-lg-2 mt-3 mt-lg-0">
                        <h6 class="text-danger mb-3">Total Impressions</h6>
                        <h1 class="display-3">{{ $fullData['total_impressions'] }}</h1>
                    </div>
                    <div class="bg-white rounded shadow-sm p-5 ml-lg-2 mt-3 mt-lg-0">
                        <h6 class="text-muted mb-3">Average CTR</h6>
                        <h1 class="display-3">{{ $fullData['average_ctr'] }}%</h1>
                    </div>
                    <div class="bg-white rounded shadow-sm p-5 ml-lg-2 mt-3 mt-lg-0">
                        <h6 class="text-muted mb-3">Average Position</h6>
                        <h1 class="display-3">{{ $fullData['average_position'] }}</h1>
                    </div>
                </div>
            @endif
            @if(!empty($dateData))
                <div class="mt-5">
                    <!-- Chart -->
                    <div id="statistics_chart" data-value="{{ $dateData }}"></div>
                </div>
            @endif
        </div>
        
        <div class="bg-white mt-5 p-5">
            <div class="nav nav-pills mb-3 py-3" id="pills-tab" role="tablist">
                <a class="btn btn-dark" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Queries</a>
                <a class="btn btn-secondary ml-3" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Pages</a>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                   <div class="table-responsive">
                    <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Top Queries</th>
                                    <th scope="col">Clicks</th>
                                    <th scope="col">Impressions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($queryData as $k => $data)
                                    @if ($k < 30)
                                        <tr>
                                            <td>{{$data['keys'][0]}}</td>
                                            <td>{{$data['clicks']}}</td>
                                            <td>{{$data['impressions']}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                    </table>
                   </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Top Pages</th>
                                    <th scope="col">Clicks</th>
                                    <th scope="col">Impressions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pagesData as $k => $data)
                                    @if ($k < 30)
                                        <tr>
                                            <td>{{$data['keys'][0]}}</td>
                                            <td>{{$data['clicks']}}</td>
                                            <td>{{$data['impressions']}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Set the redirect url and website url fields -->
    <script>
        // Set the current url without query string to redirect url
        document.getElementById('redirect_url').value = window.location.href.split('?')[0];
        // Get the root url
        document.getElementById('website_url').value = window.location.origin;
    </script>
    
</x-dynamic-component>