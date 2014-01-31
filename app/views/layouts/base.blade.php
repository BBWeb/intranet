<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Intranet</title>

    {{ HTML::style('css/bootstrap.css') }}
    {{ HTML::style('css/main.css') }}
    {{ HTML::style('css/jquery.dataTables.css') }}
</head>
<body>
  @yield('base-content')

  {{ HTML::script('/js/libs/jquery-2.0.3.js') }}
  {{ HTML::script('/js/libs/bootstrap.js') }}
  {{ HTML::script('/js/libs/underscore-min.js') }}
   @yield('footer-scripts')
</body>
</html>
