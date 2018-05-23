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
  <link rel="stylesheet" href="{{ asset('css/admins.css') }}" />

  <title>FreeRADIUS Admin</title>
</head>
<body>



  <div id='header' class='uk-margin-large-bottom'>
    <h2 class='uk-margin-left'><strong><em>FreeRADIUS</em></strong>Admin</h2>
  </div>


  <div class='uk-container uk-margin-large-top'>
    <div class='uk-grid-divider' uk-grid>


      @include('left-sidebar')


      <div id='content' class='uk-width-3-5@s'>
        <h2 class='uk-heading-line uk-text-center uk-margin-large-bottom'><span><strong>Groups</strong></span></h2>

        @if (session('info'))
        <div class='uk-alert-success' uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <p>
            {{ session('info') }}
          </p>
        </div>
        @endif

        @if (session('error'))
        <div class='uk-alert-danger' uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <p>
            {{ session('error') }}
          </p>
        </div>
        @endif




      
      </div>

      @include('right-sidebar')


    </div>
  </div>

</body>
</html>
