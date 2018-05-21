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
<body>
  <div class='uk-container'>
    <div id="header" class='uk-background-muted'>
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
    <div id="users" class='uk-background-muted'>
      <div class="uk-grid">
        <div class="uk-width-1-1 uk-margin-top">
          <h5 class="uk-heading-line"><span><strong>Add User</strong></span></h5>


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

          <div class='uk-width-2-3@s'>
            <form method="post" action="admin/add-user">
              {{ csrf_field() }}
              <div class='uk-grid'>
                <div class='uk-width-1-6@s'>
                  <input class='uk-input' type='text' placeholder='Username' name='username' required />
                </div>
                <fieldset class='uk-fieldset'>
                  <input class='uk-input uk-width-1-2@s' type='text' placeholder='Firstname' name='firstname' required />
                  <input class='uk-input uk-width-1-2@s' type='text' placeholder='Lastname' name='lastname' required />
                  <input class='uk-input uk-width-1-6@s' type='password' placeholder='Password' name='password' required />
                  <input class='uk-input uk-width-1-6@s' type='password' placeholder='Confirm Password' name='confirmPassword' required />
                </fieldset>

                <fieldset class='uk-fieldset uk-margin '>
                  <!-- <label class='uk-form-label'>Group</label> -->
                  <select class='uk-select uk-width-small@s' name='group'>
                    <option>Select Group</option>
                    @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                  </select>
                  <input type='number' class='uk-input uk-width-small@s' name='logins' placeholder='Allowed Logins' required />

                </fieldset>
              <div class="uk-margin">
                <button class="uk-button uk-button-primary" type="submit"><span uk-icon="icon: user"></span> Add User</button>
              </div>
              </div>

            </form>
          </div>
          <div class='uk-width-1-3@s'>

          </div>
        </div>



        <div class='uk-width-2-3@s uk-margin-top'>
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
        </div>
      </div>
    </div>
  </div>
</body>
</html>
