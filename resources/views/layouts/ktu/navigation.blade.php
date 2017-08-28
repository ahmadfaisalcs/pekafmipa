<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- Notifications: style can be found in dropdown.less -->
      <li class="dropdown notifications-menu notif">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-bell-o"></i>
          <span class="label label-warning">
            <span id="count">{{ count(\App\User::find(Session::get('id'))->unreadnotifications) }}</span>
          </span>
        </a>
        <ul class="dropdown-menu" id="notification_content">
          @if (count(\App\User::find(Session::get('id'))->unreadnotifications) > 0)
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                @foreach (\App\User::find(Session::get('id'))->unreadnotifications as $note)
                  <li>
                    <a href="{{ URL::to('frm_ktucheck/'.$note->data['id']) }}">
                      <i class="fa fa-envelope text-aqua"></i> {!! $note->data['data'] !!}
                      
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @else
            <li id="no_notification" class="header">You have no notifications</li>
          @endif
        </ul>
      </li>

      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img src="{{ asset('public/adminlte/dist/img/user-160.png') }}" class="user-image" alt="User Image">
          <span class="hidden-xs">Kepala Tata Usaha</span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <img src="{{ asset('public/adminlte/dist/img/user-160.png') }}" class="img-circle" alt="User Image">

            <p>
              Kepala Tata Usaha
            </p>
          </li>

          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-right">
              <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
