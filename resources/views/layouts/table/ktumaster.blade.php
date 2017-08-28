<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('page-title')</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('public/img/logo_favicon.png') }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  @include('layouts.ktu.header')
  <!-- Left side column. contains the logo and sidebar -->
  @include('layouts.ktu.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @yield('header-content')

    <!-- Main content -->
    @yield('data-content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('layouts.ktu.footer')

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset('public/adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('public/adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset('public/adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="{{ asset('public/adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('public/adminlte/plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/adminlte/dist/js/app.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/adminlte/dist/js/demo.js') }}"></script>
<!-- page script -->
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
{{-- streamlab natif --}}
<script src="{{ asset('public/StreamLab/StreamLab.js') }}"></script>
<script>
  var message, ShowDiv = $('#notification_content'), HideDiv = $('#no_notification'), count = $('#count'), c;
  var slh = new StreamLabHtml();
  var sls = new StreamLabSocket({
   appId:"{{ config('stream_lab.app_id') }}",
   channelName:"ktu",
   event:"*"
  });
  sls.socket.onmessage = function(res){
    ///res is data send from our api
    ///set this data to our class so you can use our helper function
    slh.setData(res);
    if(slh.getSource() === 'messages')
    {
      // HideDiv.hide();
      c = parseInt(count.html());
      count.html(c+1)
      if(document.getElementById('no_notification'))
      {
        document.getElementById('no_notification').style.display = 'none'; //Will hide
      }
      message = slh.getMessage();
      ShowDiv.prepend('<li><a href="{{ url('/ktu_daftar_permohonan') }}"><i class="fa fa-envelope text-aqua"></i> '+message+'</a></li>')
    }
  }
  $('.notif').on('click', function(){
    // $("#notification_content").hide();
    count.html(0);
    setTimeout(function(){
      $.get('ktuMarkAsRead', function(){});
    }, 5000);
    
    // while (ShowDiv.firstChild) {
    //   ShowDiv.removeChild(ShowDiv.firstChild);
    // }
    // if (!document.getElementById("no_notification")) {
    //   ShowDiv.append("<li id="no_notification">You have no notifications</li>");
    // }
  });
</script>
</body>
</html>
