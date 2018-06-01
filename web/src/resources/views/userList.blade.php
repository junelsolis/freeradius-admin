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


  <div class='uk-container uk-margin-large-top'>
    <div class='uk-grid-divider' uk-grid>


      @include('left-sidebar')


      <div id='content' class='uk-width-3-5@s'>
        <h2 class='uk-heading-line uk-text-center'><span><strong>All Users</strong></span></h2>

        <table class='uk-table uk-table-striped uk-table-small'>
          <thead>
            <tr>
              <th>Name</th>
              <th>Username</th>
              <th>Allowed Logins</th>
              <th>Group</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
            <tr>
              <td>{{ $user->fullname }}</td>
              <td>{{ $user->username }}</td>
              <td>{{ $user->logins }}</td>
              <td>{{ $user->group }}</td>
              <td><a href='/admin/user?id={{ $user->id }}'><span uk-icon="file-edit"></span></a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>


      @include('right-sidebar')


    </div>
  </div>

</body>
</html>
