<x-dynamic-component :component="$app->componentName">

    @php

        function initials($str) {
            $ret = '';
            foreach (explode(' ', $str) as $word)
                $ret .= strtoupper($word[0]);
            return $ret;
        }

        $credits = 0;
        $redeem = 0;
        foreach($obj->rewards as $reward){
            $credits += $reward->credits;
            $redeem += $reward->redeem;
        }

    @endphp   

    <!-- Actions -->
    <div class="d-flex justify-content-between align-ites-center bg-white px-3 rounded shadow-sm mb-3">
        <div>
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-4 font-size-sm ">
                <li class="breadcrumb-item">
                    <a href="/admin" class="text-muted text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('Loyalty.dashboard') }}"  class="text-muted text-decoration-none">{{ ucfirst($app->app) }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('Customer.index', ['filter' => 'all_data', 'query' => 'total']) }}"  class="text-muted text-decoration-none">{{ ucfirst($app->module) }}</a>
                </li>
            </ul>
            <!--end::Breadcrumb-->
        </div>
    </div>
    <!-- End Actions -->


    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-body">
            <!--begin::Top-->
            <div class="d-flex">
                <!--begin::Pic-->
                <div class="flex-shrink-0 mr-7">
                    <div class="symbol symbol-50 symbol-lg-120 symbol-light-danger">
                        <span class="font-size-h1 symbol-label font-weight-boldest">{{ initials($obj->name) }}</span>
                    </div>
                </div>
                <!--end::Pic-->
                <!--begin: Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex align-items-center justify-content-between flex-wrap mt-2">
                        <!--begin::User-->
                        <div class="mr-3">
                            <!--begin::Name-->
                            <h3 class="d-flex align-items-center text-danger font-size-h5 font-weight-bold mr-3">{{ $obj->name }}</h3>
                            <!--end::Name-->
                            <!--begin::Contacts-->
                            <div class="d-flex flex-wrap my-2">
                                <a href="#" class="text-decoration-none text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2 d-flex align-items-center"><i class="fas fa-phone mr-2"></i> {{ $obj->phone }} </a>
                                <a href="#" class="text-decoration-none text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2 d-flex align-items-center"><i class="fas fa-envelope mr-2"></i> {{ $obj->email }} </a>
                            </div>
                            <!--end::Contacts-->
                        </div>
                        <!--begin::User-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Content-->
                    <div class="d-flex align-items-center flex-wrap justify-content-between">
                        <!--begin::Address-->
                        <div class="flex-grow-1 font-weight-bold text-dark-50 py-2 py-lg-2 mr-5">
                            {{ $obj->address }}
                        </div>
                        <!--end::Address-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Top-->
            <!--begin::Separator-->
            <div class="separator separator-solid my-7"></div>
            <!--end::Separator-->
            <!--begin::Bottom-->
            <div class="d-flex align-items-center flex-wrap">
                <!--begin: Item-->
                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                    <span class="mr-4">
                        <i class="flaticon-piggy-bank icon-2x text-success font-weight-bolder"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Earnings</span>
                        <span class="font-weight-bolder font-size-h5">                         
                            {{ $credits }} 
                            <span class="text-dark-50 font-weight-bold"> points</span>
                        </span>
                    </div>
                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                    <span class="mr-4">
                        <i class="flaticon-confetti icon-2x text-danger font-weight-bolder"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Expenses</span>
                        <span class="font-weight-bolder font-size-h5">
                            {{ $redeem }} 
                            <span class="text-dark-50 font-weight-bold"> points</span>
                        </span>
                    </div>
                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                    <span class="mr-4">
                        <i class="flaticon-pie-chart icon-2x text-info font-weight-bolder"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Net</span>
                        <span class="font-weight-bolder font-size-h5">
                            {{ $credits - $redeem }} 
                            <span class="text-dark-50 font-weight-bold"> points</span>
                        </span>
                    </div>
                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                    <span class="mr-4">
                        <i class="flaticon-file-2 icon-2x text-primary font-weight-bolder"></i>
                    </span>
                    <div class="d-flex flex-column flex-lg-fill">
                        <span class="text-dark-75 font-weight-bolder font-size-sm">{{ $obj->rewards->count() }} Transactions</span>
                    </div>
                </div>
                <!--end: Item-->
            </div>
            <!--end::Bottom-->
        </div>
    </div>
    <!--end::Card-->

    <div class="bg-white p-3 rounded-lg shadow">
        <!-- Table -->
        <table class="table table-borderless bg-white">
            <tr class="border-bottom text-muted">
                <th scope="col" class="p-3">T x N</th>
                <th scope="col" class="p-3 text-center text-decoration-none">Created</th>
                <th scope="col" class="p-3 text-center text-decoration-none">User</th>
                <th scope="col" class="p-3 text-center">Activity</th>
            </tr>
            @foreach($rewards as $key=>$obj)
                <tr class="border-bottom">
                    <th scope="row" class="px-3 align-middle">{{  $obj->id }}</th>
                    <td class="px-3 align-middle text-center font-weight-bolder">{{ $obj->created_at ? $obj->created_at->diffForHumans() : '' }}</td>
                    <td class="px-3 align-middle text-center ">{{ $obj->user->name }}</td>
                    <td class="px-3 align-middle text-center font-weight-bolder {{ $obj->credits ? 'text-success' : 'text-danger' }}">{{ $obj->credits ? '+'.$obj->credits : '-'.$obj->redeem }}</td>
                </tr>
            @endforeach
        </table>
        <!-- End Table -->
        <!-- Pagination -->
            {{$rewards->links()}}
        <!-- End Pagination -->
    </div>


</x-dynamic-component>