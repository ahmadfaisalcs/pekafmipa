<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    {{-- <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('ktuinlte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
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

      <li class="{!! Request::is('ktu_daftar_permohonan') ? 'active' : '' !!}">
        <a href="{{ url('ktu_daftar_permohonan') }}"><i class="fa fa-envelope"></i>
          <span>Daftar Permohonan</span>
        </a>
      </li>

      <li class="{!! Request::is('ktu_daftar_keterangan_perbaikan') ? 'active' : '' !!}">
        <a href="{{ url('ktu_daftar_keterangan_perbaikan') }}"><i class="fa fa-exclamation-circle"></i>
          <span>Daftar Keterangan Perbaikan</span>
        </a>
      </li>

      <li class="treeview
            {!! Request::is('qo_09a') ? 'active' : '' !!}
            {!! Request::is('qo_09b') ? 'active' : '' !!}
            {!! Request::is('qo_10') ? 'active' : '' !!}
            {!! Request::is('qo_11') ? 'active' : '' !!}
            {!! Request::is('qo_12') ? 'active' : '' !!}
            {!! Request::is('qo_13') ? 'active' : '' !!}
            {!! Request::is('qo_14') ? 'active' : '' !!}
            {!! Request::is('qo_15') ? 'active' : '' !!}
            {!! Request::is('qo_16') ? 'active' : '' !!}
            {!! Request::is('qo_17') ? 'active' : '' !!}
            ">
        <a href="#">
          <i class="fa fa-check-square"></i>
            <span>Sasaran Mutu Pelayanan </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
          <ul class="treeview-menu menu-open" style="">
            <li class="{!! Request::is('qo_09a') ? 'active' : '' !!}">
              <a href="{{ url('qo_09a') }}"><i class="fa fa-circle-o"></i> Surat Keterangan</a>
            </li>
            <li class="{!! Request::is('qo_09b') ? 'active' : '' !!}">
              <a href="{{ url('qo_09b') }}"><i class="fa fa-circle-o"></i> Surat Tunjangan Anak</a>
            </li>
            <li class="{!! Request::is('qo_10') ? 'active' : '' !!}">
              <a href="{{ url('qo_10') }}"><i class="fa fa-circle-o"></i> Surat Cuti</a>
            </li>
            <li class="{!! Request::is('qo_11') ? 'active' : '' !!}">
              <a href="{{ url('qo_11') }}"><i class="fa fa-circle-o"></i> Surat Aktif Kembali</a>
            </li>
            <li class="{!! Request::is('qo_12') ? 'active' : '' !!}">
              <a href="{{ url('qo_12') }}"><i class="fa fa-circle-o"></i> Surat Undur Diri</a>
            </li>
            <li class="{!! Request::is('qo_13') ? 'active' : '' !!}">
              <a href="{{ url('qo_13') }}"><i class="fa fa-circle-o"></i> Surat SIDKOM</a>
            </li>
            <li class="{!! Request::is('qo_14') ? 'active' : '' !!}">
              <a href="{{ url('qo_14') }}"><i class="fa fa-circle-o"></i> Perpanjangan Studi</a>
            </li>
            <li class="{!! Request::is('qo_15') ? 'active' : '' !!}">
              <a href="{{ url('qo_15') }}"><i class="fa fa-circle-o"></i> SKL</a>
            </li>
            <li class="{!! Request::is('qo_16') ? 'active' : '' !!}">
              <a href="{{ url('qo_16') }}"><i class="fa fa-circle-o"></i> Percepatan Ijazah</a>
            </li>
            <li class="{!! Request::is('qo_17') ? 'active' : '' !!}">
              <a href="{{ url('qo_17') }}"><i class="fa fa-circle-o"></i> Legalisir</a>
            </li>
          </ul>
        </li>

      <li class="{!! Request::is('kepuasan_layanan') ? 'active' : '' !!}">
        <a href="{{ url('kepuasan_layanan') }}"><i class="fa fa-line-chart"></i>
          <span>Tingkat Kepuasan Layanan</span>
        </a>
      </li>

      <li class="{!! Request::is('rekapitulasi_lulusan') ? 'active' : '' !!}">
        <a href="{{ url('rekapitulasi_lulusan') }}"><i class="fa fa-graduation-cap"></i>
          <span>Rekapitulasi Lulusan</span>
        </a>
      </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
