<html>
  <div id='right-sidebar' class='uk-width-1-5@s'>

    @if (session('error'))
    <div class='uk-grid-collapse' uk-grid>
      <div class='uk-width-1-1'>
        <div class="uk-alert-danger" uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <p>{{ session('error')}}</p>
        </div>
      </div>
    </div><br /><br />
    @endif

    @if (session('info'))
    <div class='uk-grid-collapse' uk-grid>
      <div class='uk-width-1-1'>
        <div class="uk-alert-success" uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <p>{{ session('info')}}</p>
        </div>
      </div>
    </div>
    <div class='uk-width-expand'>

    </div><br /><br />
    @endif
    <ul class='uk-nav uk-nav-default'>
      Logged in as:<br />
      <strong>{{ session('fullname') }}</strong><br />
      <li class='uk-nav-divider'></li>
      <a href="#"><span uk-icon="cog"></span>&nbsp;Settings</a>
      <a href="/admin/logout"><span uk-icon="sign-out"></span>&nbsp;Logout</a>
      <div id='menu-footer' class='uk-margin-top'>
        <br />
        Author: <strong>Junel&nbsp;Solis&nbsp;MD</strong><br />
        This software is <a href="https://github.com/junelsolis/freeradius-admin" target="_blank">open source</a>.
      </div>
      <style>
        #menu-footer {
          font-size: 0.8em;
        }
        #menu-footer a {
          color: blue;
        }
      </style>
    </ul>
  </div>
</html>
