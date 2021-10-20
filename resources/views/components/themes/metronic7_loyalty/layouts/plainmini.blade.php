
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <meta charset="utf-8" />
    <title>{{ agency('meta_title') }}</title>
    <meta name="description" content="{{ agency('meta_description') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    @include('components.themes.metronic7_loyalty.blocks.styles')
    <link rel="shortcut icon" href="{{ agency('favicon_link') }}" />
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed  subheader-enabled page-loading bg-light">
    <!--begin::Main-->

    <div class="d-flex flex-column flex-root pt-4">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container" style="max-width: 500px;">
                            <div class="mt-10 mb-15 bg-white p-8 rounded">

                                <p>{{ $slot }}</p>
                        </div>
                        
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>
            <!--end::Content-->


        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Main-->

@include('components.themes.metronic7_loyalty.blocks.scrolltop')
@include('components.themes.metronic7_loyalty.blocks.scripts')
</body>
<!--end::Body-->
</html>