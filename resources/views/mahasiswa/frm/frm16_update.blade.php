@extends('layouts.mahasiswa.master')

@section('page-title')
  Formulir Surat Percepatan Ijazah
@endsection

@section('header-content')
  <section class="content-header col-md-8 col-md-offset-2">
    <h1 align="center">
      Formulir Data Mahasiswa Yang Mengajukan Surat Percepatan Ijazah
    </h1>
    <p></p>
  </section>
@endsection

@section('data-content')
  <section class="content">
    <!-- Warning -->
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="callout callout-danger">
          <h5 align="center">{{ $adm_keterangan }}.</h5>
        </div>
      </div>
    </div>
    <!-- Main row -->
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <form class="" action="{{ route('update_frm_16') }}" method="post" enctype="multipart/form-data">
          <!-- jika input field tdk lengkap -->
          @if (count($errors) > 0)
            <div class="alert alert-danger">
              Mohon maaf, ada masalah input!
              <br>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <!-- Session file ga ada -->
          @if(Session::has('warning'))
            <div align="center" class="alert alert-warning alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">
                x
              </button>
              {{ Session::get('warning') }}
            </div>
          @endif
          <!-- BOX #1 -->
          <div class="box box-info">
            <!-- box-header #1 -->
            <div class="box-header with-border">
              <h3 class="box-title">Data Mahasiswa</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $id }}">
            <div class="form-horizontal">
              <div class="box-body">
                <!-- Nama -->
                <div class="form-group {!! $errors->has('nama') ? 'has-error' : '' !!}">
                  <label for="nama" class="col-sm-3 control-label">Nama</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="{{ $form->applicant->nama }}" value="{{ $form->applicant->nama }}">
                  </div>
                </div>
                <!-- NIM -->
                <div class="form-group {!! $errors->has('nim') ? 'has-error' : '' !!}">
                  <label for="nim" class="col-sm-3 control-label">NIM</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nim" name="nim" placeholder="{{ $form->applicant->nim }}" value="{{ $form->applicant->nim }}">
                  </div>
                </div>
                <!-- Program Studi -->
                <div class="form-group">
                  <label for="program_studi" class="col-sm-3 control-label">Program Studi</label>
                  <div class="col-sm-8">
                    <select name="program_studi" class="form-control">
                      <option value="stk" @if($form->applicant->prodi == 'stk') Selected=""
                      @endif>Statistika</option>
                      <option value="gfm" @if($form->applicant->prodi == 'gfm') Selected=""
                      @endif>Geofisika dan Meteorologi</option>
                      <option value="bio" @if($form->applicant->prodi == 'bio') Selected=""
                      @endif>Biologi</option>
                      <option value="kim" @if($form->applicant->prodi == 'kim') Selected=""
                      @endif>Kimia</option>
                      <option value="mat" @if($form->applicant->prodi == 'mat') Selected=""
                      @endif>Matematika</option>
                      <option value="akt" @if($form->applicant->prodi == 'akt') Selected=""
                      @endif>Aktuaria</option>
                      <option value="kom" @if($form->applicant->prodi == 'kom') Selected=""
                      @endif>Ilmu Komputer</option>
                      <option value="fis" @if($form->applicant->prodi == 'fis') Selected=""
                      @endif>Fisika</option>
                      <option value="bik" @if($form->applicant->prodi == 'bik') Selected=""
                      @endif>Biokimia</option>
                    </select>
                  </div>
                </div>
                <!-- Semester -->
                <div class="form-group {!! $errors->has('semester') ? 'has-error' : '' !!}">
                  <label for="semester" class="col-sm-3 control-label">Semester</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="semester" name="semester" placeholder="{{ $form->applicant->semester }}" value="{{ $form->applicant->semester }}">
                  </div>
                </div>
                <!-- Untuk keperluan -->
                <div class="form-group {!! $errors->has('utk_keperluan') ? 'has-error' : '' !!}">
                  <label for="utk_keperluan" class="col-sm-3 control-label">Untuk Keperluan</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="utk_keperluan" name="utk_keperluan" placeholder="{{ $form->keperluan }}" value="{{ $form->keperluan }}">
                  </div>
                </div>
                <!-- Telp -->
                <div class="form-group {!! $errors->has('telp') ? 'has-error' : '' !!}">
                  <label for="telp" class="col-sm-3 control-label">No. Telp/HP</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="telp" name="telp" placeholder="{{ $form->applicant->telp }}" value="{{ $form->applicant->telp }}">
                  </div>
                </div>
                <!-- Email -->
                <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                  <label for="email" class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-8">
                    <input type="email" class="form-control" id="email" name="email" placeholder="{{ $form->applicant->email }}" value="{{ $form->applicant->email }}">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>

          <!-- BOX #2 -->
          <div class="box box-info">
            <!-- box-header -->
            <div class="box-header with-border">
              <h3 class="box-title">Dokumen yang harus dilampirkan (dalam format .pdf)</b></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="form">
              <div class="box-body">
                <!-- skl -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="skl">Scan Surat Keterangan Lulus Sarjana</label>
                    <p class="help-block"><a href="{{ url('storage/app/'.$lampiran->skl) }}" target="_blank">Lihat</a> SKL yang telah diupload.</p>
                    <p class="help-block">Atau lampirkan file baru:</p>
                    <input type="file" accept="application/pdf,image/*" id="skl" name="skl">
                  </div>
                </div>
                <!-- bayar wisuda -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bayar_wisuda">Scan Bukti Pembayaran Wisuda</label>
                    <p class="help-block"><a href="{{ url('storage/app/'.$lampiran->byr_wisuda) }}" target="_blank">Lihat</a> Scan Bukti yang telah diupload.</p>
                    <p class="help-block">Atau lampirkan file baru:</p>
                    <input type="file" accept="application/pdf,image/*" id="bayar_wisuda" name="bayar_wisuda">
                  </div>
                </div>
                <!-- warning -->
                <div class="callout callout-warning col-md-12">
                  <h5 align="center">Lampirkan file baru hanya jika file lama tidak sesuai. File baru yang dilampirkan akan mengganti file lama yang telah diupload sebelumnya. Klik link <b><i>Lihat</i></b> untuk melihat file lama yang telah diupload sebelumnya.</h5>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>


          <!-- Update Button -->
          <div class="box box-info">
            <div class="form-horizontal">
              <div class="box-header with-border">
                <h3 class="box-title">Selesai
                </h3>
              </div>
              <div class="box-body">
                <div class="col-sm-6">
                  <a href="{{ url('status_permohonan') }}"><button type="button" class="btn btn-block btn-danger btn-lg">Batal</button></a>
                </div>
                <div class="col-sm-6">
                  <button type="submit" class="btn btn-block btn-primary btn-lg">Perbarui Permohonan</button>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>

          <!-- terimakasih -->
          <div class="callout callout-info">
            <p align="center">Maksimal waktu pelayanan Surat Percepatan Ijazah adalah <strong>5 Hari</strong>. Cek menu <strong>Status Permohonan</strong> untuk mengetahui status formulir permohonan</p>
          </div>
        </form>
      </div>
    </div>
    <!-- /.row (main row) -->

  </section>
@endsection
