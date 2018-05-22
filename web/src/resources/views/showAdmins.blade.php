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
  <link rel="stylesheet" href="{{ asset('css/admins.css') }}" />

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
        <h2 class='uk-heading-line uk-text-center uk-margin-large-bottom'><span><strong>Administrators</strong></span></h2>

        @if ($admins)
        <ul uk-accordion='collapsible: false' class='uk-margin-large-bottom'>
          @foreach ($admins as $admin)
          <li>
            <a class='uk-accordion-title' href='#'>{{ $admin->firstname . ' ' . $admin->lastname }}</a>
            <div class='uk-accordion-content'>
              <div class='uk-grid-collapse uk-child-width-1-2@s' uk-grid>
                <div>
                  <form action='post' method='/admin/modify-admin'>
                    {{ csrf_field() }}
                    <input type='hidden' name='id' value='{{ $admin->id }}' />
                    <div class='uk-grid-small uk-child-width-1-2' uk-grid>
                      <div class='uk-width-1-1'>
                        <input class='uk-input' type='password' name='currentPassword' required placeholder='Current Password' />
                      </div>
                      <div>
                        <input class='uk-input' type='password' name='newPassword' required placeholder='New Password' />
                      </div>
                      <div>
                        <input class='uk-input' type='password' name='confirmPassword' required placeholder='Confirm Password'  />
                      </div>
                      <div class='uk-width-1-1'>
                        <button class='uk-width-1-1 uk-button uk-button-primary' type='submit'>Change Password</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div id='delete-admin' class='uk-text-center'>
                  <br />
                  <a href='/admin/delete-admin?id={{ $admin->id }}'><span uk-icon="icon: trash; ratio: 3"></span><br />DELETE</a>
                </div>
              </div>


            </div>
          </li>
          @endforeach
        </ul>
        @endif

        <div id='add-new-admin uk-margin-large-top uk-width-1-1'>
          <h3 class='uk-heading-line uk-text-right uk-margin-large-bottom subheading'><span><span uk-icon="icon: file-edit; ratio: 1.2"></span>&nbsp;Add New</span></h3>


          <form method='post' action='/admin/add-admin'>
            {{ csrf_field() }}
            <div class='uk-grid-small uk-child-width-1-2@s' uk-grid>
              <div class='uk-width-1-1'>
                <input class='uk-input' type='text' name='username' required placeholder='Enter username' />
              </div>

              <div>
                <input class='uk-input' type='text' name='firstname' required placeholder='Enter firstname' />
              </div>
              <div>
                <input class='uk-input' type='text' name='lastname' required placeholder='Enter lastname' />
              </div>
              <div>
                <input class='uk-input' type='password' name='password' required placeholder='Enter password' />
              </div>
              <div>
                <input class='uk-input' type='password' name='confirmPassword' required placeholder='Confirm Password' />
              </div>
              <div>
                <button class='uk-button uk-button-primary uk-width-1-1' type='submit'>Add Admin</button>
              </div>
            </div>
          </form>

        </div>



      </div>

      @include('right-sidebar')


    </div>
  </div>

</body>
</html>
