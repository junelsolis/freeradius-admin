<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0"> -->

  <!-- UIkit CSS -->
  <link rel="stylesheet" href="{{ asset('css/uikit.min.css') }}" />
  <!-- UIkit JS -->
  <script src="{{ asset('js/uikit.min.js') }}"></script>
  <script src="{{ asset('js/uikit-icons.min.js') }}"></script>

  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
  <title>FreeRADIUS Admin</title>
</head>
<body>



  <div id='header' class='uk-margin-large-bottom uk-margin-medium-left'>
    <h2><span id='title1'>FREERADIUS</span><span id='title2'>Admin</span></h2>
  </div>


  <div id='content' class='uk-container uk-margin-large-top'>
    <div class='uk-grid-divider' uk-grid>
      @include('left-sidebar')


      <div class='uk-width-3-5@s'>
        <h2>CONTENT GOES HERE</h2>
      </div>


      @include('right-sidebar')


    </div>
  </div>

</body>
</html>
