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
  <link rel="stylesheet" href="{{ asset('css/users.css') }}" />
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
        <h2 class='uk-heading-line'><span><strong>{{ $user->fullname }}</strong></span></h2>

        <strong>Group</strong>&nbsp;{{ $user->group }}<br />
        <strong>Logins allowed</strong>&nbsp;{{ $user->logins }}

        <h3 class='uk-heading-line subheading'><span>Modify</span></h3>

        <div class='uk-grid' uk-grid>
          @if (session('error'))
          <div class='uk-width-1-1'>
            <div class="uk-alert-danger" uk-alert>
              <a class="uk-alert-close" uk-close></a>
              <p>{{ session('error')}}</p>
            </div>
          </div><br />
          @endif

          @if (session('info'))
          <div class='uk-width-1-1'>
            <div class="uk-alert-success" uk-alert>
              <a class="uk-alert-close" uk-close></a>
              <p>{{ session('info')}}</p>
            </div>
          </div>
          @endif
        </div><br />

        <form class='uk-form-stacked' method='post' action='/admin/modify-user/change-password'>
          {{ csrf_field() }}
          <input type='hidden' name='id' value='{{ $user->id }}' />
          <div class='uk-grid-small uk-child-width-1-3@s' uk-grid>
            <div>
              <input class='uk-input' name='password' type='password' required placeholder='Enter password' />
            </div>
            <div>
              <input class='uk-input' name='confirmPassword' type='password' required placeholder='Confirm password' />
            </div>
            <div>
              <button class='uk-button uk-button-primary uk-width-1-1' type='submit'>Change Password</button>
            </div>
          </div>
        </form><br />

        <form class='uk-form-stacked' method='post' action='/admin/modify-user/change-name'>
          {{ csrf_field() }}
          <input type='hidden' name='id' value='{{ $user->id }}' />
          <div class='uk-grid-small uk-child-width-1-3@s' uk-grid>
            <div>
              <input class='uk-input' name='firstname' type='text' required placeholder='Firstname' />
            </div>
            <div>
              <input class='uk-input' name='lastname' type='text' required placeholder='Lastname' />
            </div>
            <div>
              <button class='uk-button uk-button-primary uk-width-1-1' type='submit'>Change Names</button>
            </div>
          </div>
        </form><br />

        <form class='uk-form-stacked' method='post' action='/admin/modify-user/change-logins'>
          {{ csrf_field() }}
          <input type='hidden' name='id' value='{{ $user->id }}' />
          <div class='uk-grid-small uk-child-width-1-3@s' uk-grid>
            <div>
            </div>
            <div>
              <input class='uk-input' name='logins' type='number' required />
            </div>
            <div>
              <button class='uk-button uk-button-primary uk-width-1-1' type='submit'>Change Logins</button>
            </div>
          </div>
        </form><br />
        <form class='uk-form-stacked' method='post' action='/admin/modify-user/change-group'>
          {{ csrf_field() }}
          <input type='hidden' name='id' value='{{ $user->id }}' />
          <div class='uk-grid-small uk-child-width-1-3@s' uk-grid>
            <div>
            </div>
            <div>
              <select class='uk-select' name='group'>
                <option>Select Group</option>
                @foreach ($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <button class='uk-button uk-button-primary uk-width-1-1' type='submit'>Change Group</button>
            </div>
          </div>
        </form>

      </div>


      @include('right-sidebar')

    </div>
  </div>

</body>
</html>
