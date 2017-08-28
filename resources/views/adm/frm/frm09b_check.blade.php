@extends('layouts.adm.master')

@section('page-title')
  Cek Kelengkapan Permohonan Surat Aktif Kuliah Untuk Tunjangan Anak
@endsection

@section('header-content')
  <section class="content-header col-md-8 col-md-offset-2">
    <h1 align="center">
      Cek Kelengkapan Permohonan Surat Aktif Kuliah Untuk Tunjangan Anak
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
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="{{ $form->nama }}" value="{{ $form->applicant->nama }}" >
                    </div>
                  </div>
                  <!-- NIM -->
                  <div class="form-group {!! $errors->has('nim') ? 'has-error' : '' !!}">
                    <label for="nim" class="col-sm-3 control-label">NIM</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="nim" name="nim" placeholder="{{ $form->nim }}" value="{{ $form->applicant->nim }}" >
                    </div>
                  </div>
                  <!-- Program Studi -->
                  <div class="form-group">
                    <label for="program_studi" class="col-sm-3 control-label">Program Studi</label>
                    <div class="col-sm-8">
                      <select name="program_studi" class="form-control">
                        <option value="stk" @if($form->applicant->prodi == 'stk') Selected=""
                        @endif>Statistika</option>
                        <option value="gfm" @if($form->prodi == 'gfm') Selected=""
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
                      <input type="text" class="form-control" id="semester" name="semester" placeholder="{{ $form->applicant->semester }}" value="{{ $form->semester }}" >
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
                      <input type="text" class="form-control" id="telp" name="telp" placeholder="{{ $form->telp }}" value="{{ $form->applicant->telp }}" >
                    </div>
                  </div>
                  <!-- Email -->
                  <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="email" name="email" placeholder="{{ $form->email }}" value="{{ $form->applicant->email }}" >
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <!-- BOX #2 -->
            <div class="box box-info">
              <!-- box-header #1 -->
              <div class="box-header with-border">
                <h3 class="box-title">Data Orang Tua</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="form-horizontal">
                <div class="box-body">
                  <!-- Nama -->
                  <div class="form-group {!! $errors->has('nama_ortu') ? 'has-error' : '' !!}">
                    <label for="nama_ortu" class="col-sm-3 control-label">Nama</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="nama_ortu" name="nama_ortu" placeholder="{{ $lampiran->nama_ortu }}" value="{{ $lampiran->nama_ortu }}">
                    </div>
                  </div>
                  <!-- NIP -->
                  <div class="form-group {!! $errors->has('nip') ? 'has-error' : '' !!}">
                    <label for="nip" class="col-sm-3 control-label">NIP</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="nip" name="nip" placeholder="{{ $lampiran->nip }}" value="{{ $lampiran->nip }}">
                    </div>
                  </div>
                  <!-- Pangkat golongan -->
                  <div class="form-group {!! $errors->has('pangkat') ? 'has-error' : '' !!}">
                    <label for="pangkat" class="col-sm-3 control-label">Pangkat Golongan</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="pangkat" name="pangkat" placeholder="{{ $lampiran->pangkat }}" value="{{ $lampiran->pangkat }}">
                    </div>
                  </div>
                  <!-- Instansi -->
                  <div class="form-group {!! $errors->has('instansi') ? 'has-error' : '' !!}">
                    <label for="instansi" class="col-sm-3 control-label">Instansi</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="instansi" name="instansi" placeholder="{{ $lampiran->instansi }}" value="{{ $lampiran->instansi }}">
                    </div>
                  </div>
                  <!-- Telp -->
                  <div class="form-group {!! $errors->has('telp_ortu') ? 'has-error' : '' !!}">
                    <label for="telp_ortu" class="col-sm-3 control-label">No. Telp/HP</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="telp_ortu" name="telp_ortu" placeholder="{{ $lampiran->telp_ortu }}" value="{{ $lampiran->telp_ortu }}">
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
                <h3 class="box-title">Cek Kelengkapan Dokumen Persyaratan</b></h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="form">
                <div class="box-body">
                  <!-- spp -->
                  <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-1">
                      <label for="spp">Scan SPP</label>
                      <p class="help-block"><a href="{{ url('storage/app/'.$lampiran->spp) }}" target="_blank">Lihat</a> Scan SPP yang telah diupload.</p>
                    </div>
                    <div class="col-sm-2">
                      <div class="checkbox">
                        <label>
                          <input name="chek_spp" class="cek" type="checkbox" value="SPP">
                          Lengkap
                        </label>
                      </div>
                    </div>
                  </div>
                  <!-- ktm -->
                  <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-1">
                      <label for="ktm">Scan KTM</label>
                      <p class="help-block"><a href="{{ url('storage/app/'.$lampiran->ktm) }}" target="_blank">Lihat</a> Scan KTM yang telah diupload.</p>
                    </div>
                    <div class="col-sm-2">
                      <div class="checkbox">
                        <label>
                          <input name="chek_ktm" class="cek" type="checkbox" value="KTM">
                          Lengkap
                        </label>
                      </div>
                    </div>
                  </div>
                <!-- /.box-body -->
                </div>
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
                    <h4 class="modal-title" id="myModalLabel">Form Verifikasi Dokumen Surat Keterangan Aktif Kuliah Untuk Tunjangan Anak (Bagian Tendik Adm. Pendidikan)
                    </h4>
                    <p><small>POB/FMIPA-ADM/09b/FRM-02-02 ; Tgl. 01/10/2015</small></p>
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

{{-- <!-- nomor surat -->
                <div class="form-group has-success {!! $errors->has('nomor_surat') ? 'has-error' : '' !!}">
                  <label for="nomor_surat" class="col-sm-3 control-label">Nomor Surat <small>(wajib) </small></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" placeholder="misal: 1707/IT3.7/PP/2017" @if (Request::old('nomor_surat')) value="{{Request::old('nomor_surat')}}" @else value="{{ $form->nomor_surat }}" @endif>
                  </div>
                </div> --}}