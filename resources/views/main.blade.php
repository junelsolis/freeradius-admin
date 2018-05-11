<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.css">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"
      integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
      crossorigin="anonymous">
  </script>
  <title>FreeRADIUS-MySQL Admin</title>
</head>
<body>
  <div class="ui middle aligned center aligned grid">
    <div class='three wide computer five wide mobile fourteen wide mobile column'>
      <div class='row'>
        <h3>FreeRADIUS-MySQL</h3><br /><br />
      </div>
      <div class='row'>
        <form class="ui form" method="post" action="/">
          {{ csrf_field() }}
          <div class="field">
            <label>Username</label>
            <input type="text" placeholder="Enter username" required name="username" />
          </div>
          <div class="field">
            <label>Password</label>
            <input type="password" placeholder="Enter password" required name='password' />
          </div>
          <div class="field">
            <button class="ui fluid blue button">Login</button>
          </div>
        </form>
        <br /><br />
        <a href="#">Forgot Password</a>
        <br /><br />
        <em>Created by Junel R.S. Solis</em><br />
        This project is Open Source. Find it on GitHub.
      </div>
    </div>

  </div>
</body>
</html>
