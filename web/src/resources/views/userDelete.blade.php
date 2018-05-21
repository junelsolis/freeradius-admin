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



  <div id='header' class='uk-margin-large-bottom'>
    <h2 class='uk-margin-left'><strong><em>FreeRADIUS</em></strong>Admin</h2>
  </div>


  <div class='uk-container uk-margin-large-top'>
    <div class='uk-grid-divider' uk-grid>


      @include('left-sidebar')


      <div id='content' class='uk-width-3-5@s'>
        <h2 class='uk-heading-line uk-text-center'><span><strong>Delete Users</strong></span></h2>

        <form class='uk-form-stacked uk-grid uk-margin-left uk-margin-right' action='/admin/delete-users' method='post' uk-grid>
          {{ csrf_field() }}

          @if (session('error'))
          <div class='uk-width-expand'>
            <div class="uk-alert-danger" uk-alert>
              <a class="uk-alert-close" uk-close></a>
              <p>{{ session('error')}}</p>
            </div>
          </div>
          @endif

          @if (session('info'))
          <div class='uk-width-expand'>
            <div class="uk-alert-success" uk-alert>
              <a class="uk-alert-close" uk-close></a>
              <p>{{ session('info')}}</p>
            </div>
          </div>
          @endif

          <table class='uk-table uk-table-striped uk-table-small'>
            <tbody>
              @foreach ($users as $user)
              <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->fullname }}</td>
                <td><label><input class='uk-checkbox' name='ids[]' value="{{ $user->id }}" type='checkbox' /> Delete</label></td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <button class='uk-button uk-button-primary' type='submit'>Delete Users</button>
        </form>
      </div>


      @include('right-sidebar')


    </div>
  </div>

</body>
</html>
