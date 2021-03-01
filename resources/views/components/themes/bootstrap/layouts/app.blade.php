
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="{{ client('meta_description') }}">
  <meta name="author" content="{{client('meta_author')}}">
  <title>{{ client('meta_title') }}</title>
  <link href="{{ client('favicon_link') }}" rel="icon">
  @include('components.themes.bootstrap.blocks.styles')
</head>
<body>
  @include('components.themes.bootstrap.blocks.header')

  <!-- Begin page content -->
  <main role="main" class="container">
    {{$slot}}
  </main>
 
  @include('components.themes.bootstrap.blocks.footer')
  @include('components.themes.bootstrap.blocks.scrolltop')
  @include('components.themes.bootstrap.blocks.scripts')
</body>
</html>