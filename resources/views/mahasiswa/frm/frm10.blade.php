@extends('layouts.mahasiswa.master')

@section('page-title')
  Formulir Surat Cuti Akademik
@endsection

@section('header-content')
  <section class="content-header col-md-8 col-md-offset-2">
    @if (!$isfill)
      <h1 align="center">
        Formulir Data Mahasiswa Yang Mengajukan Cuti Akademik
      </h1>
      <p></p>
    @endif
  </section>
@endsection

@section('data-content')
  <section class="content">
    <!-- Main row -->
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <form class="" action="{{ route('submit_frm_10') }}" method="post" enctype="multipart/form-data">
          <!-- kalau mhs sudah mengisi kuisioner, form kuisioner tidak usah ditampilkan lagi -->
          @if ($isfill)
            <div class="callout callout-info">
              <h2>Anda Telah Mengisi FRM-10</h2>

              <p>Terimakasih, anda telah mengisi <b>Formulir Permohonan Surat Cuti Akademik.</b> Jika anda ingin mengajukan permohonan kembali, tunggu hingga permohonan sebelumnya selesai diproses.</p>

              <p>Jika anda ingin melakukan pembaruan isian formulir surat keterangan yang telah diisi, silahkan pilih <i>link</i> <b>Perbarui</b> di ujung kanan pada tabel permohonan di menu <a href="{{  url('status_permohonan') }}"><b>Status Permohonan</b></a></p>
            </div>
          @else
            <!-- kalau mhs belum mengisi kuisioner -->
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
              {{-- <input type="hidden" name="jenis_frm" value="Surat Keterangan"> --}}
              <div class="form-horizontal">
                <div class="box-body">
                  <!-- Nama -->
                  <div class="form-group {!! $errors->has('nama') ? 'has-error' : '' !!}">
                    <label for="nama" class="col-sm-3 control-label">Nama</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="misal: Fulan Alfulani" value="{{Session::get('mhs_name')}}">
                    </div>
                  </div>
                  <!-- NIM -->
                  <div class="form-group {!! $errors->has('nim') ? 'has-error' : '' !!}">
                    <label for="nim" class="col-sm-3 control-label">NIM</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="nim" name="nim" placeholder="misal: G64130000" value="{{Session::get('nim')}}">
                    </div>
                  </div>
                  <!-- Program Studi -->
                  <div class="form-group">
                    <label for="program_studi" class="col-sm-3 control-label">Program Studi</label>
                    <div class="col-sm-8">
                      <select name="program_studi" class="form-control">
                        <option value="stk" @if (Session::get('prodi') == "stk") selected @endif>Statistika</option>
                        <option value="gfm" @if (Session::get('prodi') == "gfm") selected @endif>Geofisika dan Meteorologi</option>
                        <option value="bio" @if (Session::get('prodi') == "bio") selected @endif>Biologi</option>
                        <option value="kim" @if (Session::get('prodi') == "kim") selected @endif>Kimia</option>
                        <option value="mat" @if (Session::get('prodi') == "mat") selected @endif>Matematika</option>
                        <option value="akt" @if (Session::get('prodi') == "akt") selected @endif>Aktuaria</option>
                        <option value="kom" @if (Session::get('prodi') == "kom") selected @endif>Ilmu Komputer</option>
                        <option value="fis" @if (Session::get('prodi') == "fis") selected @endif>Fisika</option>
                        <option value="bik" @if (Session::get('prodi') == "bik") selected @endif>Biokimia</option>
                      </select>
                    </div>
                  </div>
                  <!-- Semester -->
                  <div class="form-group {!! $errors->has('semester') ? 'has-error' : '' !!}">
                    <label for="semester" class="col-sm-3 control-label">Semester</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="semester" name="semester" placeholder="misal: 8" @if(Request::old('semester')) value="{{Request::old('semester')}}" @else value="{{Session::get('semester')}}" @endif>
                    </div>
                  </div>
                  <!-- Untuk keperluan -->
                  <div class="form-group {!! $errors->has('utk_keperluan') ? 'has-error' : '' !!}">
                    <label for="utk_keperluan" class="col-sm-3 control-label">Untuk Keperluan</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="utk_keperluan" name="utk_keperluan" placeholder="misal: Sakit Hepatitis" value="{{Request::old('utk_keperluan')}}">
                    </div>
                  </div>
                  <!-- Telp -->
                  <div class="form-group {!! $errors->has('telp') ? 'has-error' : '' !!}">
                    <label for="telp" class="col-sm-3 control-label">No. Telp/HP</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="telp" name="telp" placeholder="misal: 0850123456" @if(Request::old('telp')) value="{{Request::old('telp')}}" @else value="{{Session::get('telp')}}" @endif>
                    </div>
                  </div>
                  <!-- Email -->
                  <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="email" name="email" placeholder="misal: nama@email.com" @if(Request::old('email')) value="{{Request::old('email')}}" @else value="{{Session::get('email')}}" @endif>
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
                <h3 class="box-title">Dokumen yang harus dilampirkan (dalam format PDF atau gambar)</b></h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="form">
                <div class="box-body">
                  <!-- srt cuti -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="srt_cuti">Surat Permohonan cuti dari mahasiswa dan wali</label>
                      <input type="file" accept="application/pdf,image/*" id="srt_cuti" name="srt_cuti">
                    </div>
                  </div>
                  <!-- srt pengantar -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="srt_pengantar">Surat Pengantar Departemen</label>
                      <input type="file" accept="application/pdf,image/*" id="srt_pengantar" name="srt_pengantar">
                    </div>
                  </div>
                  <!-- spp -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="spp">Scan SPP</label>
                      <input type="file" accept="application/pdf,image/*" id="spp" name="spp">
                    </div>
                  </div>
                  <!-- ktm -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="ktm">Scan KTM</label>
                      <input type="file" accept="application/pdf,image/*" id="ktm" name="ktm">
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
                  <h3 class="box-title">Selesai
                  </h3>
                </div>
                <div class="box-body">
                  <button type="submit" class="btn btn-block btn-primary btn-lg">Submit Permohonan</button>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- terimakasih -->
            <div class="callout callout-info">
              <p align="center">Maksimal waktu pelayanan Surat Keterangan adalah <strong>5 Hari</strong>. Cek menu <strong>Status Permohonan</strong> untuk mengetahui status formulir permohonan</p>

              <p align="center">Pelayanan akan dicek di hari yang sama jika waktu pengajuan permohonan tidak lebih dari pukul <strong>16.00 WIB</strong></p>
            </div>
          @endif
        </form>
      </div>
    </div>
    <!-- /.row (main row) -->

  </section>
@endsection
