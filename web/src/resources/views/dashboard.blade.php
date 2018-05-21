<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">

  <!-- UIkit CSS -->
  <link rel="stylesheet" href="{{ asset('css/uikit.min.css') }}" />
  <!-- UIkit JS -->
  <script src="{{ asset('js/uikit.min.js') }}"></script>
  <script src="{{ asset('js/uikit-icons.min.js') }}"></script>

  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
  <title>FreeRADIUS Admin</title>
</head>
<body class='uk-background-muted' style="height: 100vh;">
  <div>
    <div id="header">
      <div class="uk-grid">
        <div class="uk-width-1-2">
          <h3 class="uk-margin-left"><strong><em>FreeRADIUS</em></strong>Admin</h3>
        </div>
        <div class="uk-width-1-2">
          <p class='uk-margin-right uk-text-right uk-text-muted uk-visible@s'><span style="font-size: 0.8em;">Logged in as:</span><br />$$$$$$</p>
        </div>
      </div>
    </div><br /><br />
    <div id="statistics">

    </div>
    <div id='users' class='uk-grid uk-margin-left uk-margin-right'>
      <div class='uk-width-1-3@s'>
        <h5 class="uk-heading-line"><span><strong>New User</strong></span></h5>

        @if (session('error'))
        <div class="uk-alert-warning" uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <p>{{ session('error') }}</p>
        </div>
        @endif
        @if (session('info'))
        <div class='uk-alert-success' uk-alert>
          <a class='uk-alert-close' uk-close></a>
          <p>{{ session('info') }}</p>
        </div>
        @endif

        <form class='uk-form-stacked' method='post' action='admin/add-user'>
          {{ csrf_field() }}
          <div class='uk-grid uk-child-width-1-2@s'>
            <div class='uk-margin-bottom'>
              <input class='uk-input' type='text' name='username' placeholder='Username' required />
            </div>
            <div class=''>
            </div>
            <div class='uk-margin-bottom'>
              <input class='uk-input' type='text' name='firstname' placeholder='Firstname' required />
            </div>
            <div class='uk-margin-bottom'>
              <input class='uk-input' type='text' name='lastname' placeholder="Lastname" required />
            </div>
            <div class='uk-margin-bottom'>
              <input class='uk-input' type='password' name='password' placeholder='Password' required />
            </div>
            <div class='uk-margin-bottom'>
              <input class='uk-input' type='password' name='confirmPassword' placeholder='Confirm Password' required />
            </div>
            <div class='uk-margin-bottom'>
              <select class='uk-select' name='group' required>
                <option>Select Group</option>
                @foreach ($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
              </select>
            </div>
            <div class='uk-margin-bottom'>
              <input type='number' class='uk-input' name='logins' placeholder='Allowed Logins' required />
            </div>
            <div class='uk-margin-bottom'>
              <button class="uk-button uk-button-primary" type="submit"><span uk-icon="icon: user"></span> Add User</button>
            </div>
          </div>
        </form>
      </div>


      <div class='uk-width-2-3@s'>
        <h5 class="uk-heading-line"><span><strong>Users</strong></span></h5>
        <div class='uk-grid uk-child-width-1-4@s uk-text-center'>
          <div>
            <a href="admin/list-users">
            <span uk-icon="icon: users; ratio: 2.5"></span><br /><br />
            List All</a>
          </div>
          <div>
            <a href="admin/list-users">
            <span uk-icon="icon: minus-circle; ratio: 2.5"></span><br /><br />
            Remove</a>
          </div>
          <div>
            <a href="admin/list-users">
            <span uk-icon="icon: world; ratio: 2.5"></span><br /><br />
            Group Memberships</a>
          </div>
        </div>
      </div>
    </div>
    <div id='groups' class='uk-grid uk-margin-left uk-margin-right'>

    </div>
    <div id="">
      <div class="uk-grid">

        </div>



        <!-- <div class='uk-width-2-3@s uk-margin-top'>
          <h5 class="uk-heading-line"><span><strong>Users</strong></span></h5>
          <table class="uk-table uk-table-small uk-table-striped">
            <thead>
              <tr>
                <th>Username</th>
                <th>Name</th>
                <th>PWD Strength</th>
                <th>Allowed Logins</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->fullname }}</td>
                <td></td>
                <td>{{ $user->logins }}</td>
                <td>
                  <a class="uk-button uk-button-primary uk-button-small">Modify</a>
                  <a class="uk-button uk-button-danger uk-button-small">Delete</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div> -->
      </div>
    </div>
  </div>
</body>
</html>
