@extends('layouts.adm.master')

@section('page-title')
  Cek Kelengkapan Permohonan Sidang Komisi Pascasarjana
@endsection

@section('header-content')
  <section class="content-header col-md-8 col-md-offset-2">
    <h1 align="center">
      Cek Kelengkapan Permohonan Sidang Komisi Pascasarjana
    </h1>
    <p></p>
  </section>
@endsection

@section('data-content')
  <section class="content">
    <!-- Main row -->
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        @if ($form->status == "Proses penyelesaian surat" && $info->ktu_keterangan == "")
          <form action="{{ URL::to('adm_print_form/'.$form->id) }}" method="post" accept-charset="utf-8", target = "_blank">
            <div class="box box-info">
            <div class="form-horizontal">
              <div class="box-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-block btn-success btn-lg">Download Form</button>
                </div>
              <!-- /.box-body -->
              </div>
            </div>
          </form>
        @else
          <form class="" action="{{ route('adm_update') }}" method="post">
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
                <h3 class="box-title">Data Mahasiswa</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{ $id }}">
              <input type="hidden" name="is_allchecked" id="is_allchecked" value="0">
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
                      <input type="text" class="form-control" id="nim" name="nim" placeholder="{{ $form->applicant->nim }}" value="{{ $form->applicant->nim }}" >
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
                      <input type="text" class="form-control" id="semester" name="semester" placeholder="{{ $form->applicant->semester }}" value="{{ $form->applicant->semester }}" >
                    </div>
                  </div>
                  <!-- Untuk keperluan -->
                  <div class="form-group {!! $errors->has('utk_keperluan') ? 'has-error' : '' !!}">
                    <label for="utk_keperluan" class="col-sm-3 control-label">Untuk Keperluan</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="utk_keperluan" name="utk_keperluan" placeholder="{{ $form->keperluan }}" value="{{ $form->keperluan }}" >
                    </div>
                  </div>
                  <!-- Telp -->
                  <div class="form-group {!! $errors->has('telp') ? 'has-error' : '' !!}">
                    <label for="telp" class="col-sm-3 control-label">No. Telp/HP</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="telp" name="telp" placeholder="{{ $form->applicant->telp }}" value="{{ $form->applicant->telp }}" >
                    </div>
                  </div>
                  <!-- Email -->
                  <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="email" name="email" placeholder="{{ $form->applicant->email }}" value="{{ $form->applicant->email }}" >
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
                <h3 class="box-title">Cek Kelengkapan Dokumen Persyaratan</b></h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="form">
                <div class="box-body">
                  <!-- srt sidkom -->
                  <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-1">
                      <label for="srt_sidkom">Surat pengajuan sidang komisi dari program studi</label>
                      <p class="help-block"><a href="{{ url('storage/app/'.$lampiran->srt_sidkom) }}" target="_blank">Lihat</a> Surat Pengajuan Sidkom yang telah diupload.</p>
                    </div>
                    <div class="col-sm-2">
                      <div class="checkbox">
                        <label>
                          <input name="chek_srt_sidkom" class="cek" type="checkbox" value="Surat Pengajuan Sidang Komisi">
                          Lengkap
                        </label>
                      </div>
                    </div>
                  </div>
                  <!-- lunas spp -->
                  <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-1">
                      <label for="spp">Scan bukti lunas SPP</label>
                      <p class="help-block"><a href="{{ url('storage/app/'.$lampiran->spp) }}" target="_blank">Lihat</a> Scan Bukti Lunas SPP yang telah diupload.</p>
                    </div>
                    <div class="col-sm-2">
                      <div class="checkbox">
                        <label>
                          <input name="chek_spp" class="cek" type="checkbox" value="Bukti Lunas SPP">
                          Lengkap
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- BOX #3 -->
            <div class="box box-info">
              <!-- box-header #1 -->
              <div class="box-header with-border">
                <h3 class="box-title">Data Sidang Komisi</h3>
              </div>
              <!-- /.box-header -->
              <div class="form-horizontal">
                <div class="box-body">
                  <!-- komisi_pembimbing_1 -->
                  <div class="form-group {!! $errors->has('komisi_pembimbing_1') ? 'has-error' : '' !!}">
                    <label for="komisi_pembimbing_1" class="col-sm-3 control-label">Komisi Pembimbing 1 (Ketua)</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="komisi_pembimbing_1" name="komisi_pembimbing_1" placeholder="misal: Dr. Syamsul Falah, S.Hut, M.Si" @if(Request::old('komisi_pembimbing_1')) value="{{Request::old('komisi_pembimbing_1')}}"@else value="{{$lampiran->kombing1}}"@endif>
                    </div>
                  </div>
                  <!-- komisi_pembimbing_2 -->
                  <div class="form-group {!! $errors->has('komisi_pembimbing_2') ? 'has-error' : '' !!}">
                    <label for="komisi_pembimbing_2" class="col-sm-3 control-label">Komisi Pembimbing 2 (Anggota)</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="komisi_pembimbing_2" name="komisi_pembimbing_2" placeholder="misal: Dr. Syamsul Falah, S.Hut, M.Si" @if(Request::old('komisi_pembimbing_2')) value="{{Request::old('komisi_pembimbing_2')}}"@else value="{{$lampiran->kombing2}}"@endif>
                    </div>
                  </div>
                  <!-- hari -->
                  <div class="form-group {!! $errors->has('hari') ? 'has-error' : '' !!}">
                    <label for="hari" class="col-sm-3 control-label">Hari Pelaksanaan</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="hari" name="hari" placeholder="misal: Rabu" @if(Request::old('hari')) value="{{Request::old('hari')}}"@else value="{{$lampiran->hari}}"@endif>
                    </div>
                  </div>
                  <!-- tanggal -->
                  <div class="form-group {!! $errors->has('tanggal') ? 'has-error' : '' !!}">
                    <label for="tanggal" class="col-sm-3 control-label">Tanggal Pelaksanaan</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="misal: 22-10-2017" @if(Request::old('tanggal')) value="{{Request::old('tanggal')}}"@else value="{{$lampiran->tanggal}}"@endif>
                    </div>
                  </div>
                  <!-- jam -->
                  <div class="form-group {!! $errors->has('jam') ? 'has-error' : '' !!}">
                    <label for="jam" class="col-sm-3 control-label">Jam Pelaksanaan</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="jam" name="jam" placeholder="misal: 10.00-11.00" @if(Request::old('jam')) value="{{Request::old('jam')}}"@else value="{{$lampiran->jam}}"@endif>
                    </div>
                  </div>
                  <!-- tempat -->
                  <div class="form-group {!! $errors->has('tempat') ? 'has-error' : '' !!}">
                    <label for="tempat" class="col-sm-3 control-label">Tempat Pelaksanaan</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="tempat" name="tempat" placeholder="misal: Ruang Baca Departemen Biokimia" @if(Request::old('tempat')) value="{{Request::old('tempat')}}"@else value="{{$lampiran->tempat}}"@endif>
                    </div>
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
                  <div class="col-md-12"> <!-- col-md-offset-3 -->
                    <button type="button" class="btn btn-block btn-lg btn-primary tombol">Selesai</button>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- modal berkas tdk lengkap -->
            <div class="modal fade" id="berkastdklengkap" tabindex="-1"  aria-labelledby="myModalLabel">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Isi keterangan kekurangan/kesalahan isian formulir permohonan</h4>
                   </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="fileupload">Isi Keterangan :</label>
                      <textarea id="keterangan" name="keterangan" class="form-control" rows="2" placeholder="Isi keterangan kekurangan dokumen">{{ $form->keterangan }}</textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- modal berkas lengkap -->
            <div class="modal fade" id="berkaslengkap" tabindex="-1"  aria-labelledby="myModalLabel">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Form Verifikasi Dokumen Surat Sidkom Pascasarjana (Bagian Tendik Adm. Pendidikan)
                    </h4>
                    <p><small>POB/FMIPA-ADM/13/FRM-02-02 ; Tgl. 01/10/2015</small></p>
                   </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="fileupload">Isi Catatan Tindak Lanjut :</label>
                      <textarea name="catatan_tinjut" class="form-control" rows="2" placeholder="Isi catatan tindak lanjut (jika ada)">{{Request::old('catatan_tinjut')}}</textarea>
                    </div>
                    <!-- nomor surat -->
                    <div class="form-group">
                      <label for="nomor_surat" class="control-label">Nomor Surat <small>(wajib) </small> :</label>
                      <textarea name="nomor_surat" class="form-control" rows="1" placeholder="misal: 1707/IT3.7/PP/2017">@if(Request::old('nomor_surat')){{Request::old('nomor_surat')}}@else{{ $form->nomor_surat }}@endif</textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        @endif
        {{-- <form action="{{ URL::to('adm_print_form/'.$form->id) }}" method="post" accept-charset="utf-8">
          <div class="box box-info">
          <div class="form-horizontal">
            <div class="box-body">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{ $id }}">
              <div class="col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-block btn-success btn-lg">Download Form</button>
              </div>
            <!-- /.box-body -->
            </div>
          </div>
        </form> --}}
      </div>
    </div>
    <!-- /.row (main row) -->

  </section>
@endsection
