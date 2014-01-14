<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Intranet</title>

    {{ HTML::style('css/bootstrap.css') }}
    {{ HTML::style('css/main.css') }}
</head>
<body>
  @yield('content')

  {{ HTML::script('/js/jquery-2.0.3.js') }}
  {{ HTML::script('/js/bootstrap.js') }}
   @yield('footer-scripts')
</body>
</html>
