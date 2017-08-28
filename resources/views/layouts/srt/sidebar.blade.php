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

      <li class="{!! Request::is('srt_daftar_permohonan') ? 'active' : '' !!}">
        <a href="{{ url('srt_daftar_permohonan') }}"><i class="fa fa-envelope"></i>
          <span>Daftar Permohonan</span>
        </a>
      </li>

      <li class="{!! Request::is('srt_daftar_permohonan_selesai') ? 'active' : '' !!}">
        <a href="{{ url('srt_daftar_permohonan_selesai') }}"><i class="fa fa-check-square"></i>
          <span>Perm. Selesai Diproses</span>
        </a>
      </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
