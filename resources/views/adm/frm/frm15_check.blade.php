@extends('layouts.adm.master')

@section('page-title')
  Cek Kelengkapan Permohonan Surat Keterangan Lulus
@endsection

@section('header-content')
  <section class="content-header col-md-8 col-md-offset-2">
    <h1 align="center">
      Cek Kelengkapan Permohonan Surat Keterangan Lulus
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
                <!-- srt keterangan -->
                <div class="form-group">
                  <div class="col-sm-8 col-sm-offset-1">
                    <label for="srt_keterangan">Scan Surat keterangan Kadep</label>
                    <p class="help-block">SK dari ketua Departemen yang menyatakan telah selesai menyelesaikan semua kewajiban administrasi dan akademik</p>
                    <p class="help-block"><a href="{{ url('storage/app/'.$lampiran->srt_keterangan) }}" target="_blank">Lihat</a> Surat Keterangan yang telah diupload.</p>
                  </div>
                  <div class="col-sm-2">
                    <div class="checkbox">
                      <label>
                        <input name="chek_srt_keterangan" class="cek" type="checkbox" value="Surat Keterangan Kadep">
                        Lengkap
                      </label>
                    </div>
                  </div>
                </div>
                <!-- Pas foto -->
                <div class="form-group">
                  <div class="col-sm-8 col-sm-offset-1">
                    <label for="foto">Pas Foto Terbaru (formal)</label>
                    <p class="help-block"><a href="{{ url('storage/app/'.$lampiran->foto) }}" target="_blank">Lihat</a> Pas Foto yang telah diupload.</p>
                  </div>
                  <div class="col-sm-2">
                    <div class="checkbox">
                      <label>
                        <input name="chek_foto" class="cek" type="checkbox" value="Foto">
                        Lengkap
                      </label>
                    </div>
                  </div>
                </div>
                <!-- spp -->
                <div class="form-group">
                  <div class="col-sm-8 col-sm-offset-1">
                    <label for="spp">Tanda bukti pembayaran SPP sampai semester terakhir</label>
                    <p class="help-block"><a href="{{ url('storage/app/'.$lampiran->spp) }}">Lihat</a> Tanda Bukti yang telah diupload.</p>
                  </div>
                  <div class="col-sm-2">
                    <div class="checkbox">
                      <label>
                        <input name="chek_spp" class="cek" type="checkbox" value="Bukti Bayar SPP">
                        Lengkap
                      </label>
                    </div>
                  </div>
                </div>
                <!-- lembar pengesahan -->
                <div class="form-group">
                  <div class="col-sm-8 col-sm-offset-1">
                    <label for="lembar_pengesahan">Scan lembar pengesahan skripsi yang telah ditandatangani pembimbing dan ketua departemen</label>
                    <p class="help-block"><a href="{{ url('storage/app/'.$lampiran->lbr_pengesahan) }}" target="_blank">Lihat</a> Lembar Pengesahan yang telah diupload.</p>
                  </div>
                  <div class="col-sm-2">
                    <div class="checkbox">
                      <label>
                        <input name="chek_lembar_pengesahan" class="cek" type="checkbox" value="Lembar Pengesahan">
                        Lengkap
                      </label>
                    </div>
                  </div>
                </div>
                <!-- transkrip -->
                <div class="form-group">
                  <div class="col-sm-8 col-sm-offset-1">
                    <label for="transkrip">Transkrip kumulatif dari departemen</label>
                    <p class="help-block"><a href="{{ url('storage/app/'.$lampiran->transkrip) }}" target="_blank">Lihat</a> Transkrip Kumulatif yang telah diupload.</p>
                  </div>
                  <div class="col-sm-2">
                    <div class="checkbox">
                      <label>
                        <input name="chek_transkrip" class="cek" type="checkbox" value="Transkrip Kumulatif">
                        Lengkap
                      </label>
                    </div>
                  </div>
                </div>
                <!-- bayar wisuda -->
                <div class="form-group">
                  <div class="col-sm-8 col-sm-offset-1">
                    <label for="bayar_wisuda">Scan bukti pembayaran wisuda</label>
                    <p class="help-block"><a href="{{ url('storage/app/'.$lampiran->byr_wisuda) }}" target="_blank">Lihat</a> Scan Bukti yang telah diupload.</p>
                  </div>
                  <div class="col-sm-2">
                    <div class="checkbox">
                      <label>
                        <input name="chek_bayar_wisuda" class="cek" type="checkbox" value="Bukti Pembayaran Wisuda">
                        Lengkap
                      </label>
                    </div>
                  </div>
                </div>
                <!-- kuisioner -->
                <div class="col-sm-10 col-sm-offset-1">
                  <div class="form-group">
                    <label for="kuisioner">Kuisioner Survey Tingkat Kepuasan Lulusan FMIPA </label>
                    {{-- <p class="help-block"><a href="{{ url('storage/app/'.$form->kuisioner) }}" target="_blank">Lihat</a> Kuisioner yang telah diisi.</p> --}}
                    <p class="help-block">Kuisioner telah diisi.</p>
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
                    <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Isi keterangan kekurangan dokumen">{{ $form->keterangan }}</textarea>
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
                  <h4 class="modal-title" id="myModalLabel">Form Verifikasi Dokumen Surat Keterangan Lulus (Bagian Tendik Adm. Pendidikan)
                  </h4>
                  <p><small>POB/FMIPA-ADM/15/FRM-02-02 ; Tgl. 01/10/2015</small></p>
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
