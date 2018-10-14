<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
  <link rel='stylesheet' href="{{ asset('css/foundation.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
  <link rel='stylesheet' href="{{ asset('css/left-sidebar.css') }}" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <title>FreeRADIUS Admin | Dashboard</title>
</head>
<body>
  <div class='grid-x'>
    @include('left-sidebar')
  </div>
</body>
</html>
