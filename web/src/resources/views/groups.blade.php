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
  <link rel="stylesheet" href="{{ asset('css/groups.css') }}" />

  <title>FreeRADIUS Admin</title>
</head>
<body>



  <div id='header' class='uk-margin-large-bottom uk-margin-medium-left'>
    <h2><span id='title1'>FREERADIUS</span><span id='title2'>Admin</span></h2>
  </div>


  <div class='uk-container uk-margin-large-top'>
    <div class='uk-grid-divider' uk-grid>


      @include('left-sidebar')


      <div id='content' class='uk-width-3-5@s'>
        <h2 class='uk-heading-line uk-margin-large-bottom'><span><strong>Groups</strong></span></h2>

        @if (session('info'))
        <div class='uk-alert-success' uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <p>
            {{ session('info') }}
          </p>
        </div>
        @endif

        @if (session('error'))
        <div class='uk-alert-danger' uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <p>
            {{ session('error') }}
          </p>
        </div>
        @endif

        <div id='add-group' class='uk-margin-large-bottom'>
          <h3 class='uk-heading-line subheading'><span>Add New Group</span></h3>
            <form action='/admin/add-group' method='post'>
              {{ csrf_field() }}
              <div class='uk-grid-small' uk-grid>
                <div class='uk-width-1-2'>
                  <input class='uk-input' type='text' name='name' required placeholder='Group name' pattern="^[a-z][a-z-_\.]{3,30}$"/>
                </div>
                <div class='uk-width-1-1'>
                  <input class='uk-input' type='text' name='description' placeholder='Group description' />
                </div>
                <div class='uk-width-1-2'>
                  <button class='uk-button uk-button-primary' type='submit'>Add Group</button>
                </div>
              </div>

            </form>

        </div>

        <div id='directory'>
          <h3 class='uk-heading-line subheading'><span>Group Directory</span></h3>
          @if ($groups)
          <ul class='uk-list uk-list-striped'>
            @foreach ($groups as $group)
            <li>
              <div id='delete-group' class='uk-grid' uk-grid>
                <div class='uk-width-2-5'>
                  <strong>{{ $group->name }}</strong>&nbsp;{{ $group->description }}
                </div>
                <div class='uk-width-2-5'>
                  {{ $group->usersInGroup}}&nbsp;users
                </div>
                <div class='uk-width-1-5'>
                  <a href='/admin/delete-group?id={{ $group->id }}'><span uk-icon="icon: trash; ratio: 1"></span></a>

                </div>
              </div>
            </li>
            @endforeach
          </ul>
          @endif
        </div>



      </div>

      @include('right-sidebar')


    </div>
  </div>

</body>
</html>
