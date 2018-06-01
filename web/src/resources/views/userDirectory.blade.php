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
        <h2 class='uk-heading-line'><span><strong>User Directory</strong></span></h2>



        @foreach ($users as $item)
        <h3 class='letter uk-heading-line' id='letter-{{ $item->letter }}'><span>{{ $item->letter }}</span></h3>
        <ul uk-accordion>
          @foreach ($item->users as $user)
          <li>
            <a class="uk-accordion-title" href="#" id='user-{{ $user->id }}'><strong>{{ $user->lastname}},&nbsp;</strong>{{ $user->firstname }}</a>
            <div class="uk-accordion-content">

              <form class='uk-form-stacked' action='/admin/users/modify-user/change-username' method='post'>
                {{ csrf_field() }}
                <input name='id' type='hidden' value='{{ $user->id }}' />
                <input name='origin' type='hidden' value='admin/users' />

                <div class='uk-grid-small uk-child-width-1-3@s' uk-grid>
                  <div>
                  </div>
                  <div>
                    <input class='uk-input' name='username' type='text' value='{{ $user->username }}'required placeholder='Enter username' />
                  </div>
                  <div>
                    <button class='uk-width-1-1 uk-button uk-button-primary' type='submit'>Change Username</button>
                  </div>

                </div>
              </form><br />


              <form class='uk-form-stacked' action='/admin/users/modify-user/change-password' method='post'>
                <div class='uk-grid-small uk-child-width-1-3@s' uk-grid>
                  {{ csrf_field() }}
                  <input name='id' type='hidden' value='{{ $user->id }}' />
                  <input name='origin' type='hidden' value='/admin/users' />
                  <div>
                    <input class='uk-input' name='password' type='password' required placeholder='Enter password' />
                  </div>
                  <div>
                    <input class='uk-input' name='confirmPassword' type='password' required placeholder='Confirm password' />
                  </div>
                  <div>
                    <button class='uk-width-1-1 uk-button uk-button-primary' type='submit'>Change Password</button>
                  </div>
                </div>
              </form><br />


              <form class='uk-form-stacked' action='/admin/users/modify-user/change-name' method='post'>
                <div class='uk-grid-small uk-child-width-1-3@s' uk-grid>
                  {{ csrf_field() }}
                  <input name='id' type='hidden' value='{{ $user->id }}' />
                  <input name='origin' type='hidden' value='/admin/users' />
                  <div>
                    <input class='uk-input' name='firstname' type='text' required placeholder='First name' />
                  </div>
                  <div>
                    <input class='uk-input' name='lastname' type='text' required placeholder='Last name' />
                  </div>
                  <div>
                    <button class='uk-width-1-1 uk-button-primary uk-button' type='submit'>Change names</button>
                  </div>

                </div>
              </form><br />


              <form class='uk-form-stacked' action='/admin/users/modify-user/change-logins' method='post'>
                <div class='uk-grid-small uk-child-width-1-3@s' uk-grid>
                  {{ csrf_field() }}
                  <input name='id' type='hidden' value='{{ $user->id }}' />
                  <input name='origin' type='hidden' value='/admin/users' />
                  <div>
                  </div>
                  <div>
                    <input class='uk-input' name='logins' type='number' required placeholder='Logins allowed' />
                  </div>
                  <div>
                    <button class='uk-width-1-1 uk-button uk-button-primary' type='submit'>Change Logins</button>
                  </div>
                </div>
              </form><br />


              <form class='uk-form-stacked' action='/admin/users/modify-user/change-group' method='post'>
                <div class='uk-grid-small uk-child-width-1-3@s' uk-grid>
                  {{ csrf_field() }}
                  <input name='id' type='hidden' value='{{ $user->id }}' />
                  <input name='origin' type='hidden' value='/admin/users' />
                  <div>
                  </div>
                  <div>
                    <select class='uk-select' name='group' required>
                      <option value='' selected>Select Group</option>
                      @foreach ($groups as $group)
                      <option value="{{ $group->id }}">{{ $group->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div>
                    <button class='uk-width-1-1 uk-button uk-button-primary' type='submit'>Change Group</button>
                  </div>
                </div>
              </form><br />


              <form class='uk-form-stacked' action='/admin/users/delete-user' method='post'>
                <div class='uk-grid-small uk-child-width-1-3@s' uk-grid>
                  {{ csrf_field() }}
                  <input type='hidden' name='id' value='{{ $user->id }}' />
                  <input type='hidden' name='origin' value='/admin/users' />
                  <div>
                  </div>
                  <div>
                  </div>
                  <div>
                    <button class='uk-width-1-1 uk-button uk-button-danger' type='submit'><span uk-icon="icon: trash"></span>Delete User</button>
                  </div>
                </div>
              </form>

            </div>
          </li>
          @endforeach
        </ul>
        <br /><br />
        @endforeach

      </div>


      @include('right-sidebar')

    </div>
  </div>

</body>
</html>
