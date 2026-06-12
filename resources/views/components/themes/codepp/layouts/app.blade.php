
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Piofx Media</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="@if(isset(Session::get('settings')->favicon)){!! Session::get('settings')->favicon !!}@else /favicon.ico @endif" rel="icon">

  @include('components.themes.codepp.blocks.styles')

</head>

<body>

  @include('components.themes.codepp.blocks.header')
  @include('components.themes.codepp.blocks.preloader')
  <main id="main">
        <p>
          {{$slot}}
        </p>

  </main><!-- End #main -->

  @include('components.themes.codepp.blocks.footer')
  @include('components.themes.codepp.blocks.scrollup')
  @include('components.themes.codepp.blocks.scripts')

</body>

</html>