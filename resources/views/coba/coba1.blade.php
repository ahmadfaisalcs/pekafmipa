@extends('layouts.mahasiswa.master')

@section('page-title')
  Formulir Surat Keterangan
@endsection

@section('header-content')
  <section class="content-header col-md-8 col-md-offset-2">
    <h1 align="center">
      Formulir Data Mahasiswa Yang Mengajukan Surat Keterangan
    </h1>
    <p></p>
  </section>
@endsection

@section('data-content')
  <section class="content">
    <!-- Main row -->
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <form class="" action="{{ route('coba1_submit') }}" method="post" enctype="multipart/form-data">
          <!-- Session file ga ada -->
          @if(Session::has('warning'))
            <div align="center" class="alert alert-warning alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">
                x
              </button>
              {{ Session::get('warning') }}
            </div>
          @endif
          @if(Session::has('success'))
            <div align="center" class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">
                x
              </button>
              {{ Session::get('success') }}
            </div>
          @endif
          {{-- @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">
                x
              </button>
              {{ Session::get('success') }}
            </div>
          @endif --}}
          <!-- BOX #1 -->
          <div class="box box-info">
            <!-- box-header #1 -->
            <div class="box-header with-border">
              <h3 class="box-title">Data Mahasiswa</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="jenis_frm" value="Surat Keterangan">
            {{-- <div class="form-horizontal">
              <div class="box-body">
                <!-- Nama -->
                <div class="form-group">
                  <label for="nama" class="col-sm-3 control-label">Nama</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="">
                  </div>
                </div>
                <!-- NIM -->
                <div class="form-group">
                  <label for="nim" class="col-sm-3 control-label">NIM</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nim" name="nim" placeholder="">
                  </div>
                </div>
                <!-- Program Studi -->
                <div class="form-group">
                  <label for="program_studi" class="col-sm-3 control-label">Program Studi</label>
                  <div class="col-sm-8">
                    <select name="program_studi" class="form-control">
                      <option value="stk">Statistika</option>
                      <option value="gfm">Geofisika dan Meteorologi</option>
                      <option value="bio">Biologi</option>
                      <option value="kim">Kimia</option>
                      <option value="mat">Matematika</option>
                      <option value="akt">Aktuaria</option>
                      <option value="kom">Ilmu Komputer</option>
                      <option value="fis">Fisika</option>
                      <option value="bik">Biokimia</option>
                    </select>
                  </div>
                </div>
                <!-- Semester -->
                <div class="form-group">
                  <label for="semester" class="col-sm-3 control-label">Semester</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="semester" name="semester" placeholder="">
                  </div>
                </div>
                <!-- Untuk keperluan -->
                <div class="form-group">
                  <label for="utk_keperluan" class="col-sm-3 control-label">Untuk Keperluan</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="utk_keperluan" name="utk_keperluan" placeholder="">
                  </div>
                </div>
                <!-- Telp -->
                <div class="form-group">
                  <label for="telp" class="col-sm-3 control-label">No. Telp/HP</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="telp" name="telp" placeholder="">
                  </div>
                </div>
                <!-- Email -->
                <div class="form-group">
                  <label for="email" class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-8">
                    <input type="email" class="form-control" id="email" name="email" placeholder="">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div> --}}
          </div>
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Date picker</h3>
            </div>
            <div class="box-body">
              <!-- Date -->
              <div class="form-group">
                <label>Date:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

              <!-- Date range -->
              <div class="form-group">
                <label>Date range:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="reservation">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

              <!-- Date and time range -->
              <div class="form-group">
                <label>Date and time range:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="reservationtime">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

              <!-- Date and time range -->
              <div class="form-group">
                <label>Date range button:</label>

                <div class="input-group">
                  <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> Date range picker
                    </span>
                    <i class="fa fa-caret-down"></i>
                  </button>
                </div>
              </div>
              <!-- /.form group -->

            </div>
            <!-- /.box-body -->
          </div>

          <!-- BOX #2 -->
          <div class="box box-info">
            <!-- box-header -->
            <div class="box-header with-border">
              <h3 class="box-title">Dokumen yang harus dilampirkan (dalam format .pdf)</b></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <!-- tanggal -->
            <div class="form-group">
              <label for="tanggal" class="col-sm-3 control-label">Tanggal</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="">
              </div>
            </div>
            <div class="form">
              <div class="box-body">
                <!-- spp -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="spp">Scan SPP</label>
                    <input type="file" id="spp" name="spp">
                  </div>
                </div>
                <!-- ktm -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="ktm">Scan KTM</label>
                    <input type="file" id="ktm" name="ktm">
                  </div>
                </div>
              <!-- /.box-body -->
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="box box-info">
            <div class="form-horizontal">
              <div class="box-header with-border">
                <h3 class="box-title">Coba Button
                </h3>
              </div>
              <div class="box-body">
                <button type="submit" class="btn btn-block btn-primary btn-lg">Coba klik tombol ini</button>
              </div>
              <!-- /.box-body -->
            </div>
          </div>

          <!-- terimakasih -->
          <div class="callout callout-info">
            <p align="center">Maksimal waktu pelayanan Surat Keterangan adalah <strong>3 Hari</strong>. Cek menu <strong>Status Permohonan</strong> untuk mengetahui status formulir permohonan</p>
          </div>
        </form>
      </div>
    </div>
    <!-- /.row (main row) -->

  </section>
@endsection
