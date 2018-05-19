<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.css">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"
      integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
      crossorigin="anonymous">
  </script>
  <title>FreeRADIUS-MySQL Admin</title>
</head>
<body class="ui container">
  <div class='ui grid'>
    <div class='ui two column centered grid'>
      <div class='four column row'>
        test
      </div>
      <div class="six wide computer seven wide tablet fourteen wide mobile column">
        Stats go in here
      </div>
      <div class="six wide computer seven wide tablet fourteen wide mobile column">
        <h3>Add New User</h3>
        <form id='new-user-form' class="ui form" method="post" action="/admin/add-user">
          {{ csrf_field() }}
          <div class='field'>
            <label class="left aligned">Username</label>
            <input type="text" name='username' required placeholder="Enter username" />
          </div>
          <div class='field'>
            <label>Name</label>
            <div class="ui two fields">
              <div class="field">
                <input type="text" name="firstname" required placeholder="First Name" />
              </div>
              <div class="field">
                <input type="text" name="lastname" required placeholder="Last Name" />
              </div>
            </div>
          </div>
          <div class="field">
            <label>Password</label>
            <div class="ui two fields">
              <div class="field">
                <input type="password" name="password" required placeholder="Password" />
              </div>
              <div class="field">
                <input type="password" name="confirmPassword" required placeholder="Confirm password" />
              </div>
            </div>
          </div>
          <button class="ui blue button">Add User</button>
        </form>
      </div>

    </div>
  </div>


  </div>
</body>
</html>
