<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    {{-- <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Alexander Pierce</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form> --}}
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MENU</li>
      <li class="{!! Request::is('status_permohonan') ? 'active' : '' !!}">
        <a href="{{ url('status_permohonan') }}"><i class="fa fa-bell"></i>
          <span>Status Permohonan</span>
        </a>
      </li>
      <li class="{!! Request::is('pelayanan_online') ? 'active' : '' !!}">
        <a href="{{ url('pelayanan_online') }}"><i class="fa fa-paper-plane"></i>
          <span>Pelayanan Online</span>
        </a>
      </li>
      {{-- <li class="{!! Request::is('kuisioner_pelayanan') ? 'active' : '' !!}">
        <a href="{{ url('kuisioner_pelayanan') }}"><i class="fa fa-file-text"></i>
          <span>Kuisioner Kepuasan Layanan</span>
        </a>
      </li>
      <li class="{!! Request::is('pendataan_wisuda') ? 'active' : '' !!}">
        <a href="{{ url('pendataan_wisuda') }}"><i class="fa fa-graduation-cap"></i>
          <span>Pendataan Peserta Wisuda</span>
        </a>
      </li> --}}

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
