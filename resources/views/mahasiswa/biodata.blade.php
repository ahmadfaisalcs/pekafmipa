@extends('layouts.mahasiswa.master')

@section('page-title')
  Pendataan Peserta Pelantikan
@endsection

@section('header-content')
  <section class="content-header col-md-8 col-md-offset-2">
    {{-- @if (!$isfill) --}}
      <h1 align="center">
        Biodata Mahasiswa / Alumnus
      </h1>
      <p></p>
    {{-- @endif --}}
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
              <h2>Biodata Telah Diisi</h2>

              <p>Terimakasih, anda telah mengisi <b>Bioidata Lulusan FMIPA.</b> (^_^).</p>
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
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="misal: Fulan Alfulani" value="{{ Session::get('mhs_name') }}">
                    </div>
                  </div>
                  <!-- NIM -->
                  <div class="form-group {!! $errors->has('nim') ? 'has-error' : '' !!}">
                    <label for="nim" class="col-sm-3 control-label">NIM</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="nim" name="nim" placeholder="misal: G64130000" value="{{ Session::get('nim') }}">
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
                  <!-- Tempat Lahir -->
                  <div class="form-group {!! $errors->has('tempat_lahir') ? 'has-error' : '' !!}">
                    <label for="tempat_lahir" class="col-sm-3 control-label">Tempat Lahir</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="misal: Bogor" value="{{ Request::old('tempat_lahir') }}">
                    </div>
                  </div>
                  <!-- Tanggal Lahir -->
                  <div class="form-group {!! $errors->has('tanggal_lahir') ? 'has-error' : '' !!}">
                    <label for="tanggal_lahir" class="col-sm-3 control-label">Tanggal Lahir</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder="misal: 18-07-1995" value="{{ Request::old('tanggal_lahir') }}">
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
                  <!-- Agama -->
                  <div class="form-group">
                    <label for="agama" class="col-sm-3 control-label">Agama</label>
                    <div class="col-sm-8">
                      <select name="agama" class="form-control">
                        @if (Request::old('agama') == 'budha' or Request::old('agama') == '')
                          <option value="budha">Budha</option>
                        @endif
                        @if (Request::old('agama') == 'hindu' or Request::old('agama') == '')
                          <option value="hindu">Hindu</option>
                        @endif
                        @if (Request::old('agama') == 'islam' or Request::old('agama') == '')
                          <option value="islam">Islam</option>
                        @endif
                        @if (Request::old('agama') == 'katolik' or Request::old('agama') == '')
                          <option value="katolik">Katolik</option>
                        @endif
                        @if (Request::old('agama') == 'konghucu' or Request::old('agama') == '')
                          <option value="konghucu">Kong Hu Cu</option>
                        @endif
                        @if (Request::old('agama') == 'protestan' or Request::old('agama') == '')
                          <option value="protestan">Protestan</option>
                        @endif
                      </select>
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
              <!-- form start -->
              <div class="form-horizontal">
                <div class="box-body">
                  <!-- Asal SD -->
                  <div class="form-group {!! $errors->has('asal_sd') ? 'has-error' : '' !!}">
                    <label for="asal_sd" class="col-sm-2 control-label">Asal SD</label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="asal_sd" name="asal_sd" placeholder="misal: SDN 1 Babakan Raya" value="{{Request::old('asal_sd')}}">
                    </div>
                    <label for="tahun_lulus_sd" class="col-sm-2 control-label">Tahun Lulus SD</label>
                    <div class="col-sm-2">
                      <input type="text" class="form-control" id="tahun_lulus_sd" name="tahun_lulus_sd" placeholder="misal: 2007" value="{{Request::old('tahun_lulus_sd')}}">
                    </div>
                  </div>
                  <!-- Asal SMP -->
                  <div class="form-group {!! $errors->has('asal_smp') ? 'has-error' : '' !!}">
                    <label for="asal_smp" class="col-sm-2 control-label">Asal SMP</label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="asal_smp" name="asal_smp" placeholder="misal: SMPN 1 Babakan Tengah" value="{{Request::old('asal_smp')}}">
                    </div>
                    <label for="tahun_lulus_smp" class="col-sm-2 control-label">Tahun Lulus SMP</label>
                    <div class="col-sm-2">
                      <input type="text" class="form-control" id="tahun_lulus_smp" name="tahun_lulus_smp" placeholder="misal: 2010" value="{{Request::old('tahun_lulus_smp')}}">
                    </div>
                  </div>
                  <!-- Asal SMA -->
                  <div class="form-group {!! $errors->has('asal_sma') ? 'has-error' : '' !!}">
                    <label for="asal_sma" class="col-sm-2 control-label">Asal SMA</label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="asal_sma" name="asal_sma" placeholder="misal: SMAN 1 Babakan Lebak" value="{{Request::old('asal_sma')}}">
                    </div>
                    <label for="tahun_lulus_sma" class="col-sm-2 control-label">Tahun Lulus SMA</label>
                    <div class="col-sm-2">
                      <input type="text" class="form-control" id="tahun_lulus_sma" name="tahun_lulus_sma" placeholder="misal: 2013" value="{{Request::old('tahun_lulus_sma')}}">
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- BOX #3 -->
            <div class="box box-info">
              <!-- form start -->
              <div class="form-horizontal">
                <div class="box-body">
                  <!-- Jalur Masuk -->
                  <div class="form-group">
                    <label for="jalur_masuk" class="col-sm-3 control-label">Jalur Masuk IPB</label>
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
                  <!-- Tahun Masuk -->
                  <div class="form-group {!! $errors->has('tahun_masuk') ? 'has-error' : '' !!}">
                    <label for="tahun_masuk" class="col-sm-3 control-label">Tahun Masuk IPB</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tahun_masuk" name="tahun_masuk" placeholder="misal: 2013" value="{{ Request::old('tahun_masuk') }}">
                    </div>
                  </div>
                  <!-- Tanggal Lulus -->
                  <div class="form-group {!! $errors->has('tanggal_lulus') ? 'has-error' : '' !!}">
                    <label for="tanggal_lulus" class="col-sm-3 control-label">Tanggal Lulus FMIPA</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tanggal_lulus" name="tanggal_lulus" placeholder="misal: 18-07-2017" value="{{ Request::old('tanggal_lulus') }}">
                    </div>
                  </div>
                  <!-- tahun Lulus -->
                  <div class="form-group {!! $errors->has('tahun_lulus') ? 'has-error' : '' !!}">
                    <label for="tahun_lulus" class="col-sm-3 control-label">Tahun Lulus FMIPA</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus" placeholder="misal: 2017" value="{{ Request::old('tahun_lulus') }}">
                    </div>
                  </div>
                  <!-- Judul Laporan -->
                  <div class="form-group {!! $errors->has('judul_laporan') ? 'has-error' : '' !!}">
                    <label class="col-sm-3 control-label">Judul Skripsi</label>
                    <div class="col-sm-8">
                      <textarea name="judul_laporan" class="form-control" rows="2" placeholder="misal: Sistem Pelayanan Akademik dan Kemahasiswaan FMIPA IPB Berbasis Web">{{ Request::old('judul_laporan') }}</textarea>
                    </div>
                  </div>
                  <!-- Dosen Pembimbing 1 -->
                  <div class="form-group {!! $errors->has('dosbing1') ? 'has-error' : '' !!}">
                    <label for="dosbing1" class="col-sm-3 control-label">Dosen Pembimbing 1</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="dosbing1" name="dosbing1" placeholder="misal: Fulan (tanpa gelar)" value="{{ Request::old('dosbing1') }}">
                    </div>
                  </div>
                  <!-- Dosen Pembimbing 2 -->
                  <div class="form-group {!! $errors->has('dosbing2') ? 'has-error' : '' !!}">
                    <label for="dosbing2" class="col-sm-3 control-label">Dosen Pembimbing 2</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="dosbing2" name="dosbing2" placeholder="misal: Alfulani (tanpa gelar)" value="{{ Request::old('dosbing2') }}">
                    </div>
                  </div>
                  <!-- Dosen Pembimbing 3 -->
                  <div class="form-group {!! $errors->has('dosbing3') ? 'has-error' : '' !!}">
                    <label for="dosbing3" class="col-sm-3 control-label">Dosen Pembimbing 3</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="dosbing3" name="dosbing3" placeholder="misal: Alfulani (tanpa gelar)" value="{{ Request::old('dosbing3') }}">
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- BOX #4 -->
            <div class="box box-info">
              <!-- form start -->
              <div class="form-horizontal">
                <div class="box-body">
                  <!-- IPK Tk. 1 dan 2 -->
                  <div class="form-group {!! $errors->has('ipk_tingkat_1') ? 'has-error' : '' !!}">
                    <label for="ipk_tingkat_1" class="col-sm-2 col-sm-offset-1 control-label">IPK Tingkat 1</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="ipk_tingkat_1" name="ipk_tingkat_1" placeholder="misal: 3.00" value="{{Request::old('ipk_tingkat_1')}}">
                    </div>
                    <label for="ipk_tingkat_2" class="col-sm-2 control-label">IPK Tingkat 2</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="ipk_tingkat_2" name="ipk_tingkat_2" placeholder="misal: 3.12" value="{{Request::old('ipk_tingkat_2')}}">
                    </div>
                  </div>
                  <!-- IPK Tk. 3 dan 4 -->
                  <div class="form-group {!! $errors->has('ipk_tingkat_3') ? 'has-error' : '' !!}">
                    <label for="ipk_tingkat_3" class="col-sm-2 col-sm-offset-1 control-label">IPK Tingkat 3</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="ipk_tingkat_3" name="ipk_tingkat_3" placeholder="misal: 3.00" value="{{Request::old('ipk_tingkat_3')}}">
                    </div>
                    <label for="ipk_tingkat_4" class="col-sm-2 control-label">IPK Tingkat 4</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="ipk_tingkat_4" name="ipk_tingkat_4" placeholder="misal: 3.12" value="{{Request::old('ipk_tingkat_4')}}">
                    </div>
                  </div>
                  <!-- IP Kumulatif dan Predikat -->
                  <div class="form-group {!! $errors->has('ipk') ? 'has-error' : '' !!}">
                    <label for="ipk" class="col-sm-2 col-sm-offset-1 control-label">IP Kumulatif</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="ipk" name="ipk" placeholder="misal: 3.00" value="{{Request::old('ipk')}}">
                    </div>
                    <label for="predikat" class="col-sm-2 control-label">Predikat</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="predikat" name="predikat" placeholder="misal: Memuaskan" value="{{Request::old('predikat')}}">
                    </div>
                  </div>
                  <!-- jumlah sks -->
                  <div class="form-group {!! $errors->has('ipk') ? 'has-error' : '' !!}">
                    <label for="jumlah_sks" class="col-sm-2 col-sm-offset-1 control-label">Jumlah SKS</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="jumlah_sks" name="jumlah_sks" placeholder="misal: 144" value="{{Request::old('jumlah_sks')}}">
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
                  <!-- Alamat lengkap -->
                  <div class="form-group {!! $errors->has('alamat_lengkap') ? 'has-error' : '' !!}">
                    <label class="col-sm-3 control-label">Alamat Lengkap Sekarang</label>
                    <div class="col-sm-8">
                      <textarea name="alamat_lengkap" class="form-control" rows="2" placeholder="misal: Jalan Babakan Lio No. 20, Dramaga, Bogor">{{ Request::old('alamat_lengkap') }}</textarea>
                    </div>
                  </div>
                  <!-- Telp -->
                  <div class="form-group {!! $errors->has('telp') ? 'has-error' : '' !!}">
                    <label for="telp" class="col-sm-3 control-label">Telpon/HP</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="telp" name="telp" placeholder="misal: 080012345678" value="{{ Request::old('telp') }}">
                    </div>
                  </div>
                  <!-- Pekerjaan -->
                  <div class="form-group {!! $errors->has('pekerjaan') ? 'has-error' : '' !!}">
                    <label for="tanggal_lulus" class="col-sm-3 control-label">Pekerjaan Alumni</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="misal: Karyawan Swasta" value="{{ Request::old('pekerjaan') }}">
                    </div>
                  </div>
                  <!-- Alamat lengkap -->
                  <div class="form-group {!! $errors->has('alamat_tempat_kerja') ? 'has-error' : '' !!}">
                    <label class="col-sm-3 control-label">Alamat Tempat Bekerja</label>
                    <div class="col-sm-8">
                      <textarea name="alamat_tempat_kerja" class="form-control" rows="2" placeholder="misal: Jalan Babakan Lio No. 20, Dramaga, Bogor">{{ Request::old('alamat_tempat_kerja') }}</textarea>
                    </div>
                  </div>
                  <!-- nama_ortu -->
                  <div class="form-group {!! $errors->has('nama_ortu') ? 'has-error' : '' !!}">
                    <label for="nama_ortu" class="col-sm-3 control-label">Nama Orang Tua</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="nama_ortu" name="nama_ortu" placeholder="misal: Fulan (tanpa gelar)" value="{{ Request::old('nama_ortu') }}">
                    </div>
                  </div>
                  <!-- Alamat ortu -->
                  <div class="form-group {!! $errors->has('alamat_ortu') ? 'has-error' : '' !!}">
                    <label class="col-sm-3 control-label">Alamat Orang Tua</label>
                    <div class="col-sm-8">
                      <textarea name="alamat_ortu" class="form-control" rows="2" placeholder="misal: Jalan Babakan Lio No. 20, Dramaga, Bogor">{{ Request::old('alamat_ortu') }}</textarea>
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
                <div class="box-body">
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
                    <label for="tahun_akademik" class="col-sm-3 control-label">Tahun Akademik Wisuda</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tahun_akademik" name="tahun_akademik" placeholder="ex: 2017/2018" @if (!empty($data_satisfy)) value="{{ $data_satisfy->tahun_akademik }}" @else value="{{ Request::old('tahun_akademik') }}" @endif >
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
              <p align="center">Terimakasih telah mengisi biodata lulusan (^_^)</p>
            </div>
          @endif
        </form>
      </div>
    </div>
    <!-- /.row (main row) -->

  </section>
@endsection

{{-- <!-- Periode Wisuda -->
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
                      <input type="text" class="form-control" id="tanggal_wisuda" name="tanggal_wisuda" placeholder="misal: 26-07-2016" @if (!empty($data_satisfy)) value="{{ $data_satisfy->tanggal_wisuda }}" @else value="{{ Request::old('tanggal_wisuda') }}" @endif>
                    </div>
                  </div>
                  <!-- Tahun Akademik -->
                  <div class="form-group {!! $errors->has('tahun_akademik') ? 'has-error' : '' !!}">
                    <label for="tahun_akademik" class="col-sm-3 control-label">Tahun Akademik</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tahun_akademik" name="tahun_akademik" placeholder="misal: 2017/2018" @if (!empty($data_satisfy)) value="{{ $data_satisfy->tahun_akademik }}" @else value="{{ Request::old('tahun_akademik') }} @endif ">
                    </div>
                  </div> 


                  <!-- IPK -->
                  <div class="form-group {!! $errors->has('ipk') ? 'has-error' : '' !!}">
                    <label for="ipk" class="col-sm-3 control-label">IPK</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="ipk" name="ipk" placeholder="misal: 3.45" @if(!empty($data_satisfy->ipk)) value="{{ $data_satisfy->ipk }}" @else value="{{ Request::old('ipk') }}" @endif >
                    </div>
                  </div>
                  <!-- Predikat -->
                  <div class="form-group {!! $errors->has('predikat') ? 'has-error' : '' !!}">
                    <label for="predikat" class="col-sm-3 control-label">Predikat</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="predikat" name="predikat" placeholder="misal: Cumlaude" value="{{ Request::old('predikat') }}">
                    </div>
                  </div>
                  --}}