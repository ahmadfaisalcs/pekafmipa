@extends('layouts.mahasiswa.master')

@section('page-title')
  Kuisioner Tingkat Kepuasan
@endsection

@section('header-content')
  <section class="content-header col-md-8 col-md-offset-2">
    @if (!$isfill)
      <h1 align="center">
      Survei Tingkat Kepuasan Lulusan FMIPA
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
        <form class="" action="{{ route('submit_kuisioner') }}" method="post">
          <!-- kalau mhs sudah mengisi kuisioner, form kuisioner tidak usah ditampilkan lagi -->
          @if ($isfill)
            <div class="callout callout-info">
              <h2>Kuisioner Telah Diisi</h2>

              <p>Terimakasih, anda telah mengisi <b>Kuisioner Tingkat Kepuasan Layanan Lulusan FMIPA.</b> Semoga hari anda menyenangkan (^_^).</p>
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
            <!-- BOX #1 -->
            <div class="box box-info">
              <!-- box-header #1 -->
              <div class="box-header with-border">
                <h3 class="box-title">Form Isian</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                  <!-- Departemen -->
                  <div class="form-group">
                    <label for="departemen" class="col-sm-3 control-label">Departemen</label>
                    <div class="col-sm-8">
                      <select name="departemen" class="form-control">
                        <option value="stk" @if (Session::get('prodi') == "stk") selected @endif>Statistika</option>
                        <option value="gfm" @if (Session::get('prodi') == "gfm") selected @endif>Geofisika dan Meteorologi</option>
                        <option value="bio" @if (Session::get('prodi') == "bio") selected @endif>Biologi</option>
                        <option value="kim" @if (Session::get('prodi') == "kim") selected @endif>Kimia</option>
                        <option value="mat" @if (Session::get('prodi') == "mat") selected @endif>Matematika</option>
                        <option value="kom" @if (Session::get('prodi') == "kom") selected @endif>Ilmu Komputer</option>
                        <option value="fis" @if (Session::get('prodi') == "fis") selected @endif>Fisika</option>
                        <option value="bik" @if (Session::get('prodi') == "bik") selected @endif>Biokimia</option>
                      </select>
                    </div>
                  </div>
                  <!-- Jenis Kelamin -->
                  <div class="form-group">
                    <label for="jenis_kelamin" class="col-sm-3 control-label">Jenis Kelamin</label>
                    <div class="col-sm-8">
                      <select name="jenis_kelamin" class="form-control">
                        @if (Request::old('jenis_kelamin') == 'lk' or Request::old('jenis_kelamin') == '')
                          <option value="lk">Laki-laki</option>
                        @endif
                        @if (Request::old('jenis_kelamin') == 'pr' or Request::old('jenis_kelamin') == '')
                          <option value="pr">Perempuan</option>
                        @endif
                      </select>
                    </div>
                  </div>
                  <!-- Jalur Masuk -->
                  <div class="form-group">
                    <label for="jalur_masuk" class="col-sm-3 control-label">Jalur Masuk</label>
                    <div class="col-sm-8">
                      <select name="jalur_masuk" class="form-control">
                        <option value="snm" @if (Request::old('jalur_masuk') == "snm") selected @endif>SNMPTN</option>
                        <option value="sbm" @if (Request::old('jalur_masuk') == "sbm") selected @endif>SBMPTN</option>
                        <option value="utm" @if (Request::old('jalur_masuk') == "utm") selected @endif>UTM</option>
                        <option value="pin" @if (Request::old('jalur_masuk') == "pin") selected @endif>PIN</option>
                        <option value="bud" @if (Request::old('jalur_masuk') == "bud") selected @endif>BUD</option>
                      </select>
                    </div>
                  </div>
                  <!-- Periode Wisuda -->
                  <div class="form-group">
                    <label for="periode_wisuda" class="col-sm-3 control-label">Periode Wisuda</label>
                    <div class="col-sm-8">
                      <select name="periode_wisuda" class="form-control">
                        @if(!empty($data_graduate))
                          <option value="1" @if (($data_graduate->periode_wisuda) == "1") selected @endif>1</option>
                          <option value="2" @if (($data_graduate->periode_wisuda) == "2") selected @endif>2</option>
                          <option value="3" @if (($data_graduate->periode_wisuda) == "3") selected @endif>3</option>
                          <option value="4" @if (($data_graduate->periode_wisuda) == "4") selected @endif>4</option>
                          <option value="5" @if (($data_graduate->periode_wisuda) == "5") selected @endif>5</option>
                          <option value="6" @if (($data_graduate->periode_wisuda) == "6") selected @endif>6</option>
                          <option value="7" @if (($data_graduate->periode_wisuda) == "7") selected @endif>7</option>
                          <option value="8" @if (($data_graduate->periode_wisuda) == "8") selected @endif>8</option>
                        @else
                          <option value="1" @if (Request::old('periode_wisuda') == "1") selected @endif>1</option>
                          <option value="2" @if (Request::old('periode_wisuda') == "2") selected @endif>2</option>
                          <option value="3" @if (Request::old('periode_wisuda') == "3") selected @endif>3</option>
                          <option value="4" @if (Request::old('periode_wisuda') == "4") selected @endif>4</option>
                          <option value="5" @if (Request::old('periode_wisuda') == "5") selected @endif>5</option>
                          <option value="6" @if (Request::old('periode_wisuda') == "6") selected @endif>6</option>
                          <option value="7" @if (Request::old('periode_wisuda') == "7") selected @endif>7</option>
                          <option value="8" @if (Request::old('periode_wisuda') == "8") selected @endif>8</option>
                        @endif
                      </select>
                    </div>
                  </div>
                  <!-- Tanggal wisuda -->
                  <div class="form-group {!! $errors->has('predikat') ? 'has-error' : '' !!}">
                    <label for="tanggal_wisuda" class="col-sm-3 control-label">Tanggal Wisuda</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tanggal_wisuda" name="tanggal_wisuda" placeholder="misal: 26-07-2016" @if(!empty($data_graduate)) value="{{ $data_graduate->tanggal_wisuda }}" @else value="{{ Request::old('tanggal_wisuda') }}" @endif>
                    </div>
                  </div>
                  <!-- Tahun Akademik -->
                  <div class="form-group {!! $errors->has('tahun_akademik') ? 'has-error' : '' !!}">
                    <label for="tahun_akademik" class="col-sm-3 control-label">Tahun Akademik (wisuda)</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tahun_akademik" name="tahun_akademik" placeholder="misal: 2017/2018" @if(!empty($data_graduate)) value="{{ $data_graduate->tahun_akademik }}" @else value="{{ Request::old('tahun_akademik') }}" @endif>
                    </div>
                  </div>
                  <!-- Tahun Masuk -->
                  <div class="form-group {!! $errors->has('tahun_masuk') ? 'has-error' : '' !!}">
                    <label for="tahun_masuk" class="col-sm-3 control-label">Tahun Masuk</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tahun_masuk" name="tahun_masuk" placeholder="misal: 2013/2014" value="{{Request::old('tahun_masuk')}}">
                    </div>
                  </div>
                  <!-- IPK -->
                  <div class="form-group {!! $errors->has('ipk') ? 'has-error' : '' !!}">
                    <label for="ipk" class="col-sm-3 control-label">IPK</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="ipk" name="ipk" placeholder="misal: 3.45" @if(!empty($data_graduate)) value="{{ $data_graduate->ipk }}" @else value="{{Request::old('ipk')}}" @endif>
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
                <h3 class="box-title">Penilaian Terhadap Akademik <b>Departemen</b></h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="form-horizontal">
                <div class="box-body">
                  <!-- Kuliah -->
                  <div class="form-group {!! $errors->has('kuliah') ? 'has-error' : '' !!}">
                    <label for="kuliah" class="col-sm-3 control-label">Kuliah</label>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="kuliah" id="kuliah1" value="1" @if (Request::old('kuliah') == 1) checked @endif>
                        Tidak Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="kuliah" id="kuliah2" value="2" @if (Request::old('kuliah') == 2) checked @endif>
                        Cukup Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="kuliah" id="kuliah3" value="3" @if (Request::old('kuliah') == 3) checked @endif>
                        Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="kuliah" id="kuliah4" value="4" @if (Request::old('kuliah') == 4) checked @endif>
                        Sangat Puas
                      </label>
                    </div>
                  </div>
                  <!-- Praktikum -->
                  <div class="form-group {!! $errors->has('praktikum') ? 'has-error' : '' !!}">
                    <label for="praktikum" class="col-sm-3 control-label">Praktikum</label>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="praktikum" id="praktikum1" value="1" @if (Request::old('praktikum') == 1) checked @endif>
                        Tidak Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="praktikum" id="praktikum2" value="2" @if (Request::old('praktikum') == 2) checked @endif>
                        Cukup Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="praktikum" id="praktikum3" value="3" @if (Request::old('praktikum') == 3) checked @endif>
                        Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="praktikum" id="praktikum4" value="4" @if (Request::old('praktikum') == 4) checked @endif>
                        Sangat Puas
                      </label>
                    </div>
                  </div>
                  <!-- Penelitian -->
                  <div class="form-group {!! $errors->has('penelitian') ? 'has-error' : '' !!}">
                    <label for="penelitian" class="col-sm-3 control-label">Penelitian</label>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="penelitian" id="penelitian1" value="1" @if (Request::old('penelitian') == 1) checked @endif>
                        Tidak Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="penelitian" id="penelitian2" value="2" @if (Request::old('penelitian') == 2) checked @endif>
                        Cukup Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="penelitian" id="penelitian3" value="3" @if (Request::old('penelitian') == 3) checked @endif>
                        Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="penelitian" id="penelitian4" value="4" @if (Request::old('penelitian') == 4) checked @endif>
                        Sangat Puas
                      </label>
                    </div>
                  </div>
                  <!-- Pembimbingan -->
                  <div class="form-group {!! $errors->has('pembimbingan') ? 'has-error' : '' !!}">
                    <label for="pembimbingan" class="col-sm-3 control-label">Pembimbingan</label>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="pembimbingan" id="pembimbingan1" value="1" @if (Request::old('pembimbingan') == 1) checked @endif>
                        Tidak Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="pembimbingan" id="pembimbingan2" value="2" @if (Request::old('pembimbingan') == 2) checked @endif>
                        Cukup Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="pembimbingan" id="pembimbingan3" value="3" @if (Request::old('pembimbingan') == 3) checked @endif>
                        Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="pembimbingan" id="pembimbingan4" value="4" @if (Request::old('pembimbingan') == 4) checked @endif>
                        Sangat Puas
                      </label>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- BOX #3 -->
            <div class="box box-info">
              <!-- box-header -->
              <div class="box-header with-border">
                <h3 class="box-title">Penilaian Terhadap Non Akademik <b>Departemen</b></h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="form-horizontal">
                <div class="box-body">
                  <!-- Adm Akademik Departemen -->
                  <div class="form-group  {!! $errors->has('administrasi_departemen') ? 'has-error' : '' !!}">
                    <label for="administrasi_departemen" class="col-sm-3 control-label">Administrasi Akademik Dep.</label>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="administrasi_departemen" id="administrasi_departemen1" value="1" @if (Request::old('administrasi_departemen') == 1) checked @endif>
                        Tidak Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="administrasi_departemen" id="administrasi_departemen2" value="2" @if (Request::old('administrasi_departemen') == 2) checked @endif>
                        Cukup Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="administrasi_departemen" id="administrasi_departemen3" value="3" @if (Request::old('administrasi_departemen') == 3) checked @endif>
                        Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="administrasi_departemen" id="administrasi_departemen4" value="4" @if (Request::old('administrasi_departemen') == 4) checked @endif>
                        Sangat Puas
                      </label>
                    </div>
                  </div>
                  <!-- Kebersihan Departemen -->
                  <div class="form-group {!! $errors->has('kebersihan_departemen') ? 'has-error' : '' !!}">
                    <label for="kebersihan_departemen" class="col-sm-3 control-label">Kebersihan Departemen</label>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="kebersihan_departemen" id="kebersihan_departemen1" value="1" @if (Request::old('kebersihan_departemen') == 1) checked @endif>
                        Tidak Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="kebersihan_departemen" id="kebersihan_departemen2" value="2" @if (Request::old('kebersihan_departemen') == 2) checked @endif>
                        Cukup Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="kebersihan_departemen" id="kebersihan_departemen3" value="3" @if (Request::old('kebersihan_departemen') == 3) checked @endif>
                        Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="kebersihan_departemen" id="kebersihan_departemen4" value="4" @if (Request::old('kebersihan_departemen') == 4) checked @endif>
                        Sangat Puas
                      </label>
                    </div>
                  </div>
                  <!-- Tiolet Departemen -->
                  <div class="form-group {!! $errors->has('toilet_departemen') ? 'has-error' : '' !!}">
                    <label for="toilet_departemen" class="col-sm-3 control-label">Toilet Departemen</label>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="toilet_departemen" id="toilet_departemen1" value="1" @if (Request::old('toilet_departemen') == 1) checked @endif>
                        Tidak Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="toilet_departemen" id="toilet_departemen2" value="2" @if (Request::old('toilet_departemen') == 2) checked @endif>
                        Cukup Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="toilet_departemen" id="toilet_departemen3" value="3" @if (Request::old('toilet_departemen') == 3) checked @endif>
                        Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="toilet_departemen" id="toilet_departemen4" value="4" @if (Request::old('toilet_departemen') == 4) checked @endif>
                        Sangat Puas
                      </label>
                    </div>
                  </div>
                  <!-- Hotspot Departemen -->
                  <div class="form-group {!! $errors->has('hotspot_departemen') ? 'has-error' : '' !!}">
                    <label for="hotspot_departemen" class="col-sm-3 control-label">Hotspot Departemen</label>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="hotspot_departemen" id="hotspot_departemen1" value="1" @if (Request::old('hotspot_departemen') == 1) checked @endif>
                        Tidak Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="hotspot_departemen" id="hotspot_departemen2" value="2" @if (Request::old('hotspot_departemen') == 2) checked @endif>
                        Cukup Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="hotspot_departemen" id="hotspot_departemen3" value="3" @if (Request::old('hotspot_departemen') == 3) checked @endif>
                        Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="hotspot_departemen" id="hotspot_departemen4" value="4" @if (Request::old('hotspot_departemen') == 4) checked @endif>
                        Sangat Puas
                      </label>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- BOX #4 -->
            <div class="box box-info">
              <!-- box-header -->
              <div class="box-header with-border">
                <h3 class="box-title">Penilaian Terhadap Non Akademik <b>Dekanat FMIPA</b></h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="form-horizontal">
                <div class="box-body">
                  <!-- Adm Akademik Dekanat -->
                  <div class="form-group {!! $errors->has('administrasi_dekanat') ? 'has-error' : '' !!}">
                    <label for="administrasi_dekanat" class="col-sm-3 control-label">Administrasi Akademik Dek.</label>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="administrasi_dekanat" id="administrasi_dekanat1" value="1" @if (Request::old('administrasi_dekanat') == 1) checked @endif>
                        Tidak Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="administrasi_dekanat" id="administrasi_dekanat2" value="2" @if (Request::old('administrasi_dekanat') == 2) checked @endif>
                        Cukup Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="administrasi_dekanat" id="administrasi_dekanat3" value="3" @if (Request::old('administrasi_dekanat') == 3) checked @endif>
                        Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="administrasi_dekanat" id="administrasi_dekanat4" value="4" @if (Request::old('administrasi_dekanat') == 4) checked @endif>
                        Sangat Puas
                      </label>
                    </div>
                  </div>
                  <!-- Kebersihan Dekanat -->
                  <div class="form-group {!! $errors->has('kebersihan_dekanat') ? 'has-error' : '' !!}">
                    <label for="kebersihan_dekanat" class="col-sm-3 control-label">Kebersihan Dekanat</label>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="kebersihan_dekanat" id="kebersihan_dekanat1" value="1" @if (Request::old('kebersihan_dekanat') == 1) checked @endif>
                        Tidak Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="kebersihan_dekanat" id="kebersihan_dekanat2" value="2" @if (Request::old('kebersihan_dekanat') == 2) checked @endif>
                        Cukup Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="kebersihan_dekanat" id="kebersihan_dekanat3" value="3" @if (Request::old('kebersihan_dekanat') == 3) checked @endif>
                        Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="kebersihan_dekanat" id="kebersihan_dekanat4" value="4" @if (Request::old('kebersihan_dekanat') == 4) checked @endif>
                        Sangat Puas
                      </label>
                    </div>
                  </div>
                  <!-- Tiolet Dekanat -->
                  <div class="form-group {!! $errors->has('toilet_dekanat') ? 'has-error' : '' !!}">
                    <label for="toilet_dekanat" class="col-sm-3 control-label">Toilet Dekanat</label>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="toilet_dekanat" id="toilet_dekanat1" value="1" @if (Request::old('toilet_dekanat') == 1) checked @endif>
                        Tidak Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="toilet_dekanat" id="toilet_dekanat2" value="2" @if (Request::old('toilet_dekanat') == 2) checked @endif>
                        Cukup Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="toilet_dekanat" id="toilet_dekanat3" value="3" @if (Request::old('toilet_dekanat') == 3) checked @endif>
                        Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="toilet_dekanat" id="toilet_dekanat4" value="4" @if (Request::old('toilet_dekanat') == 4) checked @endif>
                        Sangat Puas
                      </label>
                    </div>
                  </div>
                  <!-- Hotspot Dekanat -->
                  <div class="form-group {!! $errors->has('hotspot_dekanat') ? 'has-error' : '' !!}">
                    <label for="hotspot_dekanat" class="col-sm-3 control-label">Hotspot Dekanat</label>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="hotspot_dekanat" id="hotspot_dekanat1" value="1" @if (Request::old('hotspot_dekanat') == 1) checked @endif>
                        Tidak Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="hotspot_dekanat" id="hotspot_dekanat2" value="2" @if (Request::old('hotspot_dekanat') == 2) checked @endif>
                        Cukup Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="hotspot_dekanat" id="hotspot_dekanat3" value="3" @if (Request::old('hotspot_dekanat') == 3) checked @endif>
                        Puas
                      </label>
                    </div>
                    <div class="radio col-sm-2">
                      <label>
                        <input type="radio" name="hotspot_dekanat" id="hotspot_dekanat4" value="4" @if (Request::old('hotspot_dekanat') == 4) checked @endif>
                        Sangat Puas
                      </label>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- BOX #5 -->
            <div class="box box-info">
              <!-- form start -->
              <div class="form-horizontal">
                <div class="box-body">
                  <!-- Saran -->
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Saran</label>
                    <div class="col-sm-10">
                      <textarea name="saran" class="form-control" rows="4" placeholder="Saran untuk perbaikan fasilitas / pelayanan FMIPA ...">{{Request::old('saran')}}</textarea>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- BOX #6 -->
            <div class="box box-info">
              <!-- form start -->
              <div class="form-horizontal">
                <div class="box-header with-border">
                  <h3 class="box-title">Selesai
                  </h3>
                </div>
                <div class="box-body">
                  <button type="submit" class="btn btn-block btn-primary btn-lg">Submit Kuisioner</button>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- terimakasih -->
            <div class="callout callout-info">
              <p align="center">Terimakasih telah mengisi kuisioner (^_^)</p>
            </div>
          @endif
        </form>
      </div>
    </div>
    <!-- /.row (main row) -->

  </section>
@endsection
