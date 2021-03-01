
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Piofx Media</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  @include('components.themes.codepp.blocks.styles')

</head>

<body>


  <main id="main" class="mt-4">
    <section class="inner-page">
      <div class="container">
        <p>
          {{$slot}}
        </p>
      </div>
    </section>
  </main><!-- End #main -->

  

  @include('components.themes.codepp.blocks.scripts')

</body>

</html>