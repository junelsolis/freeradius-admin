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
  <div id='header' class='uk-margin'>
    <h2 class='uk-margin-left'><strong><em>FreeRADIUS</em></strong>Admin</h2>
  </div>
  <div id='content' class='uk-container uk-margin-top'>
    <div class='uk-grid-divider' uk-grid>
      <div class='uk-width-1-5@s'>
        <ul class='uk-nav uk-nav-default'>
          <li class='uk-nav-header'><span uk-icon="user"></span> Users</li>
          <li><a href="admin/adduser">Add User</a></li>
          <li><a href="#">List All</a></li>
          <li><a href="#">Delete</a></li>
          <li><a href="#">Group Memberships</a></li>
          <li class='uk-nav-divider'></li>
          <li class='uk-nav-header'><span uk-icon="users"></span> Groups</li>
          <li><a href='#'>Add Group</a></li>
          <li><a href="#">List All</a></li>
          <li class='uk-nav-divider'></li>
        </ul>
      </div>
      <div class='uk-width-3-5@s'>
        <h2>CONTENT GOES HERE</h2>
      </div>
      <div id='right-sidebar' class='uk-width-1-5@s'>
        <ul class='uk-nav uk-nav-default'>
          Logged in as:<br />
          <strong>Michael Flurry</strong><br />
          <li class='uk-nav-divider'></li>
          <a href="#"><span uk-icon="cog"></span>&nbsp;Settings</a>
          <a href="#"><span uk-icon="sign-out"></span>&nbsp;Logout</a>
        </ul>

      </div>
    </div>

  </div>

</body>
</html>
