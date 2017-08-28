<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pelayanan Akademik dan Kemahasiswaan FMIPA IPB</title>
  <link rel="icon" href="{{ asset('public/img/logo_favicon.png') }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/dist/css/skins/_all-skins.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="" class="navbar-brand"><b>Pelayanan Akademik dan Kemahasiswaan FMIPA-IPB</b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          </button>
        </div>
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Main content -->
      <section class="content">
        <!-- Callout Info -->
        <div class="callout callout-info" align="center">
          <h4>Selamat Datang di Sistem Pelayanan Akademik dan Kemahasiswaan FMIPA IPB</h4>
        </div>
        <!-- Session (kalau bukan mhs FMIPA) -->
        @if(Session::has('warning'))
          <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">
              x
            </button>
            {{ Session::get('warning') }}
          </div>
        @endif
        <div class="row">
          <!-- Box Login -->
          <div class="col-md-4 col-md-push-8">
            @if (count($errors) > 0)
              <div class="alert alert-danger">
                Mohon maaf, ada masalah input ID / password!
                <br>
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">Login</h3>
              </div>
              <form action="{{ url('/auth') }}" role="form" method="post">
              <div class="box-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                  <label for="username">ID akun</label>
                  <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="{{ Request::old('username') }}">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="password" placeholder="Password" name="password" value="{{ Request::old('password') }}">
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Login</button>
              </div>
            </form>
              <!-- /.box-body -->
            </div>
          </div>
          <!-- Box Info -->
          <div class="col-md-8 col-md-pull-4">
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">Sistem ini dibuat sebagai alternatif pengajuan permohonan pelayanan akademik dan kemahasiswaan FMIPA-IPB secara <i>online</i></h3>
              </div>
              <div class="box-body">
                <p>Pelayanan akademik dan kemahasiswaan yang dapat diajukan antara lain:</p>
                <ul>
                  <li>POB/FMIPA-ADM/09/FRM-01a-01— <b>Surat Keterangan</b></li>
                  <li>POB/FMIPA-ADM/09/FRM-01b-01— <b>Surat Keterangan Aktif Kuliah Untuk Tunjangan Anak</b></li>
                  <li>POB/FMIPA-ADM/09/FRM-10-01— <b>Surat Cuti Akademik</b></li>
                  <li>POB/FMIPA-ADM/09/FRM-11-01— <b>Surat Aktif Kembali</b></li>
                  <li>POB/FMIPA-ADM/09/FRM-12-01— <b>Surat Undur Diri</b></li>
                  <li>POB/FMIPA-ADM/09/FRM-13-01— <b>Surat Sidang Komisi Pascasarjana</b></li>
                  <li>POB/FMIPA-ADM/09/FRM-14-01— <b>Surat Perpanjangan Studi</b></li>
                  <li>POB/FMIPA-ADM/09/FRM-15-01— <b>Surat Keterangan Lulus</b></li>
                  <li>POB/FMIPA-ADM/09/FRM-16-01— <b>Surat Percepatan Ijazah</b></li>
                  <li>POB/FMIPA-ADM/09/FRM-17-01— <b>Legalisir</b></li>
                </ul>
                <p>Mahasiswa login dengan menggunakan ID dan <i>password</i> akun mahasiswa IPB.</p>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        Template by: <b>AdminLTE</b>
      </div>
      <small>dev: @ahmadfaisal_cs</small>
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset('public/adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('public/adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('public/adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('public/adminlte/plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/adminlte/dist/js/app.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/adminlte/dist/js/demo.js') }}"></script>
</body>
</html>
