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
    <div id="content" class='uk-background-muted'>
      <div class="uk-grid uk-margin-left uk-margin-right uk-margin">
        <div class="uk-width-1-3@s uk-margin-top">
          <h5 class="uk-heading-line"><span><strong>Add User</strong></span></h5>
          <form class='uk-form-horizontal' method="post" action="admin/add-user">
            {{ csrf_field() }}
              <div class='uk-width-auto@s uk-margin'>
                <input class='uk-input' type='text' placeholder='Username' name='username' required />
              </div>
              <div class='uk-fieldset uk-margin'>
                <input class='uk-input uk-width-1-3' type='text' placeholder='Firstname' name='firstname' required />
                <input class='uk-input uk-width-1-3' type='text' placeholder='Lastname' name='lastname' required />
              </div>

              <fieldset class='uk-fieldset'>

                <input class='uk-input' type='password' placeholder='Password' name='password' required />
              </fieldset>

            <div class="uk-margin">
              <button class="uk-button uk-button-primary" type="submit"><span uk-icon="icon: user"></span>  Add User</button>
            </div>
          </form>
        </div>
        <div class='uk-width-2-3@s uk-margin-top uk-margin-bottom'>
          <h5 class="uk-heading-line"><span><strong>Users</strong></span></h5>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec condimentum ornare quam, eget eleifend ipsum interdum quis. Suspendisse scelerisque nulla malesuada nibh fermentum, pharetra fermentum velit consequat. Nam et arcu molestie, auctor ex quis, sagittis enim. Nam tincidunt nulla sagittis nisl vulputate aliquam.<br /><br />
        </div>
      </div>
    </div>
  </div>
</body>
</html>
