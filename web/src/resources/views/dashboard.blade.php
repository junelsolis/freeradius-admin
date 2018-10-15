<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
  <link rel='stylesheet' href="{{ asset('css/foundation.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
  <link rel='stylesheet' href="{{ asset('css/left-sidebar.css') }}" />
  <link rel='stylesheet' href="{{ asset('css/right-sidebar.css') }}" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500" rel="stylesheet">
  <title>FreeRADIUS Admin | Dashboard</title>
</head>
<body>
  <div class='grid-x'>
    @include('left-sidebar')
    <div id='main' class='cell medium-8'>
      <div id='stats' class='grid-x'>
        <div class='cell small-12'>
          <h1>Statistics</h1>
        </div>
        <div class='stat cell small-3'>
          <h2 class='number'>{{ $totalUsers }}</h2>
          <h2 class='title'>Users</h2>
        </div>
        <div class='stat cell small-3'>
          <h2 class='number'>{{ $totalGroups }}</h2>
          <h2 class='title'>Groups</h2>
        </div>
        <div class='stat cell small-3'>
          <h2 class='number'>{{ $totalNas }}</h2>
          <h2 class='title'>NAS</h2>
        </div>
      </div>

      <div class='section'>
        <h5>How to Use</h5>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>
      </div>

      <div class='section'>
        <h5>Server Configuration</h5>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>
      </div>
    </div>
    @include('right-sidebar')
  </div>
</body>
</html>
