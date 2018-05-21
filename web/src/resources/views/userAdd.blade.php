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
        <h2 class='uk-heading-line uk-text-center'><span><strong>Add User</strong></span></h2>

        <form class='uk-form-stacked uk-child-width-1-2@s uk-margin uk-grid' action='/admin/add-user' method='post' uk-grid>
          {{ csrf_field() }}

          @if (session('error'))
          <div class='uk-width-1-1'>
            <div class="uk-alert-danger" uk-alert>
              <a class="uk-alert-close" uk-close></a>
              <p>{{ session('error')}}</p>
            </div>
          </div>
          @endif

          @if (session('info'))
          <div class='uk-width-1-1'>
            <div class="uk-alert-success" uk-alert>
              <a class="uk-alert-close" uk-close></a>
              <p>{{ session('info')}}</p>
            </div>
          </div>
          @endif

          <div>
            <label class='uk-form-label'>Username</label>
            <input class='uk-input' name='username' type='text' required placeholder='Username' />
          </div>
          <div>
          </div>
          <div>
            <label class='uk-form-label'>First Name</label>
            <input class='uk-input' name='firstname' type='text' required placeholder='First Name' />
          </div>
          <div>

            <label class='uk-form-label'>Last Name</label>
            <input class='uk-input' name='lastname' type='text' required placeholder='Last Name' />
          </div>
          <div>
            <label class='uk-form-label'>Password</label>
            <input class='uk-input' name='password' type='password' required placeholder="Enter a password" />
          </div>
          <div>
            <label class='uk-form-label'>Confirm Password</label>
            <input class='uk-input' name='confirmPassword' type='password' required placeholder='Enter the password again to confirm.' />
          </div>
          <div>
            <label class='uk-form-label'>Select Group</label>
            <select class='uk-select' name='group'>
              <option disabled>Select Group</option>
              @foreach ($groups as $group)
              <option value="{{ $group->id }}">{{ $group->name }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class='uk-form-label'>Allowed Logins</label>
            <input class='uk-input' name='logins' type='number' required />
          </div>
          <div class='uk-width-1-1@s'>
            <button class='uk-button uk-button-primary' type='submit'>Add User</button>
          </div>
        </form>
      </div>


      @include('right-sidebar')


    </div>
  </div>

</body>
</html>
