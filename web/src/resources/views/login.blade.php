<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
  <link rel='stylesheet' href="{{ asset('css/foundation.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <title>FreeRADIUS Admin</title>
</head>
<body>
  <div id='main'>
    <img src="{{ asset('images/fradmin-logo.svg') }}"/>

    <div class='form'>
      <form method='post' action='/'>
        {{ csrf_field() }}

        <label>Username</label>
        <input type='text' name='username' required />
        <label>Password</label>
        <input type='password' name='password' required />

        <button class='button expanded' type='submit'>Login</button>
      </form>
    </div>
  </div>
  <div id='footer'>
    <p>
      Created by <a href='https://www.junelsolis.com' target="_blank">Junel Solis</a><br />
      FreeRADIUS Admin is <a href='https://www.github.com/junelsolis/freeradius-admin' target='_blank'>open source</a>.
    </p>
  </div>
</body>
</html>
