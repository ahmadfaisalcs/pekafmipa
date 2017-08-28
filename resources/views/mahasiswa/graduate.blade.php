@extends('layouts.mahasiswa.master')

@section('page-title')
  Pendataan Peserta Pelantikan
@endsection

@section('header-content')
  <section class="content-header col-md-8 col-md-offset-2">
    @if (!$isfill)
      <h1 align="center">
        Pendataan Peserta Pelantikan Sarjana FMIPA IPB
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
        <form class="" action="{{ route('submit_wisuda') }}" method="post">
        <!-- kalau mhs sudah mengisi kuisioner, form kuisioner tidak usah ditampilkan lagi -->
          @if ($isfill)
            <div class="callout callout-info">
              <h2>Pendataan Peserta Pelantikan Wisuda Telah Diisi</h2>

              <p>Terimakasih, anda telah mengisi <b>Pendataan Peserta Pelantikan wisuda.</b> Semoga anda dilancarkan sampai wisuda nanti. Sampai berjumpa di GWW (^_^).</p>
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
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="ex: Fulan Alfulani" value="{{ Session::get('mhs_name') }}">
                    </div>
                  </div>
                  <!-- NIM -->
                  <div class="form-group {!! $errors->has('nim') ? 'has-error' : '' !!}">
                    <label for="nim" class="col-sm-3 control-label">NIM</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="nim" name="nim" placeholder="ex: G64130000" value="{{ Session::get('nim') }}">
                    </div>
                  </div>
                  <!-- Tempat Lahir -->
                  <div class="form-group {!! $errors->has('tempat_lahir') ? 'has-error' : '' !!}">
                    <label for="tempat_lahir" class="col-sm-3 control-label">Tempat Lahir</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="ex: Bogor" value="{{ Request::old('tempat_lahir') }}">
                    </div>
                  </div>
                  <!-- Tanggal Lahir -->
                  <div class="form-group {!! $errors->has('tanggal_lahir') ? 'has-error' : '' !!}">
                    <label for="tanggal_lahir" class="col-sm-3 control-label">Tanggal Lahir</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder="ex: 18-07-1995" value="{{ Request::old('tanggal_lahir') }}">
                    </div>
                  </div>
                  <!-- Program Studi -->
                  <div class="form-group">
                    <label for="program_studi" class="col-sm-3 control-label">Departemen</label>
                    <div class="col-sm-8">
                      <select name="program_studi" class="form-control">
                        <option value="stk" @if (Session::get('prodi') == "stk") selected @endif>Statistika</option>
                        <option value="gfm" @if (Session::get('prodi') == "gfm") selected @endif>Geofisika dan Meteorologi</option>
                        <option value="bio" @if (Session::get('prodi') == "bio") selected @endif>Biologi</option>
                        <option value="kim" @if (Session::get('prodi') == "kim") selected @endif>Kimia</option>
                        <option value="mat" @if (Session::get('prodi') == "mat") selected @endif>Matematika</option>
                        {{-- <option value="akt" @if (Request::old('program_studi') == "akt") selected @endif>Aktuaria</option> --}}
                        <option value="kom" @if (Session::get('prodi') == "kom") selected @endif>Ilmu Komputer</option>
                        <option value="fis" @if (Session::get('prodi') == "fis") selected @endif>Fisika</option>
                        <option value="bik" @if (Session::get('prodi') == "bik") selected @endif>Biokimia</option>
                      </select>
                    </div>
                  </div>
                  <!-- Tanggal Lulus -->
                  <div class="form-group {!! $errors->has('tanggal_lulus') ? 'has-error' : '' !!}">
                    <label for="tanggal_lulus" class="col-sm-3 control-label">Tanggal Lulus</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tanggal_lulus" name="tanggal_lulus" placeholder="ex: 18-07-2017" value="{{ Request::old('tanggal_lulus') }}">
                    </div>
                  </div>
                  <!-- Judul Laporan -->
                  <div class="form-group {!! $errors->has('judul_laporan') ? 'has-error' : '' !!}">
                    <label class="col-sm-3 control-label">Judul Laporan</label>
                    <div class="col-sm-8">
                      <textarea name="judul_laporan" class="form-control" rows="2" placeholder="ex: Sistem Pelayanan Akademik dan Kemahasiswaan FMIPA IPB Berbasis Web">{{ Request::old('judul_laporan') }}</textarea>
                    </div>
                  </div>
                  <!-- Dosen Pembimbing 1 -->
                  <div class="form-group {!! $errors->has('dosbing1') ? 'has-error' : '' !!}">
                    <label for="dosbing1" class="col-sm-3 control-label">Dosen Pembimbing 1</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="dosbing1" name="dosbing1" placeholder="ex: Fulan (tanpa gelar)" value="{{ Request::old('dosbing1') }}">
                    </div>
                  </div>
                  <!-- Dosen Pembimbing 2 -->
                  <div class="form-group {!! $errors->has('dosbing2') ? 'has-error' : '' !!}">
                    <label for="dosbing2" class="col-sm-3 control-label">Dosen Pembimbing 2</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="dosbing2" name="dosbing2" placeholder="ex: Alfulani (tanpa gelar)" value="{{ Request::old('dosbing2') }}">
                    </div>
                  </div>
                  <!-- IPK -->
                  <div class="form-group {!! $errors->has('ipk') ? 'has-error' : '' !!}">
                    <label for="ipk" class="col-sm-3 control-label">IPK</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="ipk" name="ipk" placeholder="ex: 3.45" @if(!empty($data_satisfy->ipk)) value="{{ $data_satisfy->ipk }}" @else value="{{ Request::old('ipk') }}" @endif >
                    </div>
                  </div>
                  <!-- Predikat -->
                  <div class="form-group {!! $errors->has('predikat') ? 'has-error' : '' !!}">
                    <label for="predikat" class="col-sm-3 control-label">Predikat</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="predikat" name="predikat" placeholder="ex: Cumlaude" value="{{ Request::old('predikat') }}">
                    </div>
                  </div>
                  <!-- Periode Wisuda -->
                  <div class="form-group">
                    <label for="periode_wisuda" class="col-sm-3 control-label">Periode Wisuda</label>
                    <div class="col-sm-8">
                      <select name="periode_wisuda" class="form-control">
                        @if (!empty($data_satisfy))
                          <option value="1" @if (($data_satisfy->periode_wisuda) == "1") selected @endif>1</option>
                          <option value="2" @if (($data_satisfy->periode_wisuda) == "2") selected @endif>2</option>
                          <option value="3" @if (($data_satisfy->periode_wisuda) == "3") selected @endif>3</option>
                          <option value="4" @if (($data_satisfy->periode_wisuda) == "4") selected @endif>4</option>
                          <option value="5" @if (($data_satisfy->periode_wisuda) == "5") selected @endif>5</option>
                          <option value="6" @if (($data_satisfy->periode_wisuda) == "6") selected @endif>6</option>
                          <option value="7" @if (($data_satisfy->periode_wisuda) == "7") selected @endif>7</option>
                          <option value="8" @if (($data_satisfy->periode_wisuda) == "8") selected @endif>8</option>
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
                      <input type="text" class="form-control" id="tanggal_wisuda" name="tanggal_wisuda" placeholder="ex: 26-07-2016" @if (!empty($data_satisfy)) value="{{ $data_satisfy->tanggal_wisuda }}" @else value="{{ Request::old('tanggal_wisuda') }}" @endif>
                    </div>
                  </div>
                  <!-- Tahun Akademik -->
                  <div class="form-group {!! $errors->has('tahun_akademik') ? 'has-error' : '' !!}">
                    <label for="tahun_akademik" class="col-sm-3 control-label">Tahun Akademik</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tahun_akademik" name="tahun_akademik" placeholder="ex: 2017/2018" @if (!empty($data_satisfy)) value="{{ $data_satisfy->tahun_akademik }}" @else value="{{ Request::old('tahun_akademik') }} @endif ">
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- Submit Button -->
            <div class="box box-info">
              <!-- form start -->
              <div class="form-horizontal">
                <div class="box-header with-border">
                  <h3 class="box-title">Selesai
                  </h3>
                </div>
                <div class="box-body">
                  <button type="submit" class="btn btn-block btn-primary btn-lg">Submit Pendataan</button>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- terimakasih -->
            <div class="callout callout-info">
              <p align="center">Terimakasih telah mengisi pendataan wisuda (^_^)</p>
            </div>
          @endif
        </form>
      </div>
    </div>
    <!-- /.row (main row) -->

  </section>
@endsection
