@extends('layouts.ktu.master')

@section('page-title')
  Cek Kelengkapan Permohonan Surat Keterangan
@endsection

@section('header-content')
  <section class="content-header col-md-8 col-md-offset-2">
    <h1 align="center">
      Cek Kelengkapan Permohonan {{ $app->jenis_frm }}
    </h1>
    <p></p>
  </section>
@endsection

@section('data-content')
  <section class="content">
    <!-- Main row -->
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <form class="" action="{{ route('ktu_update') }}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="{{ $id }}">
          <input type="hidden" id="iscomplete" name="iscomplete" value="0">
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
          {{-- <!-- BOX #1 -->
          <div class="box box-info">
            <!-- box-header #1 -->
            <div class="box-header with-border">
              <h3 class="box-title">Surat</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $id }}">
            <div class="form">
              <div class="box-body">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="spp">Surat yang telah di-<i>generate</i> oleh sistem:</label>
                    <p class="help-block"><a href="{{ url('storage/app/'.$form->spp) }}" target="_blank">Lihat</a> surat.</p>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div> --}}

          <!-- BOX #2 -->
          <div class="box box-info">
            <!-- box-header -->
            <div class="box-header with-border">
              <h3 class="box-title">Catatan Tindak Lanjut:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="form">
              <div class="box-body">
                <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody>
                  <tr>
                    <th></th>
                    <th>Tendik. Administrasi Pendidikan</th>
                    <th>Kepala Tata Usaha</th>
                    <th>Tendik. Persuratan</th>
                  </tr>
                  <tr>
                    <th>Tanggal:</th>
                    <td>{{ Carbon\Carbon::parse($info->adm_waktu_tinjut)->format('d/m/Y') }}</td>
                    <td>-</td>
                    <td>-</td>
                  </tr>
                  <tr>
                    <th>Jam:</th>
                    <td>{{ Carbon\Carbon::parse($info->adm_waktu_tinjut)->format('H:i') }}</td>
                    <td>-</td>
                    <td>-</td>
                  </tr>
                  <tr>
                    <th>Catatan Tindak Lanjut</th>
                    <td>{{ $info->adm_catatan_tinjut }}</td>
                    <td>-</td>
                    <td>-</td>
                  </tr>
                </tbody>
              </table>
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
                <div class="col-md-6">
                  <button data-target="#berkastdklengkap" data-toggle="modal" type="button" class="btn btn-block btn-danger btn-lg tdklengkap">Berkas Tidak Lengkap</button>
                </div>
                <div class="col-md-6">
                  <button data-target="#berkaslengkap" data-toggle="modal" type="button" class="btn btn-block btn-primary btn-lg lengkap">Berkas Lengkap</button>
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
										<textarea name="keterangan" class="form-control" rows="2" placeholder="Isi keterangan kekurangan dokumen">@if(Request::old('keterangan')){{ Request::old('keterangan') }}@else{{ $info->ktu_keterangan }}@endif{{ Request::old('keterangan') }}</textarea>
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
									<h4 class="modal-title" id="myModalLabel">Form Verifikasi Dokumen Surat Keterangan (Bagian Kepala Tata Usaha)
                  </h4>
                  <p><small>POB/FMIPA-ADM/FRM-02-02 ; Tgl. 01/10/2015</small></p>
								 </div>
								<div class="modal-body">
									<div class="form-group">
									  <label for="fileupload">Isi Catatan Tindak Lanjut :</label>
										<textarea name="catatan_tinjut" class="form-control" rows="2" placeholder="Isi catatan tindak lanjut (jika ada)">{{Request::old('catatan_tinjut')}}</textarea>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>
							</div>
						</div>
					</div>
          {{-- <!-- terimakasih -->
          <div class="callout callout-info">
            <p align="center">Maksimal waktu pelayanan Surat Keterangan adalah <strong>3 Hari</strong>. Cek menu <strong>Status Permohonan</strong> untuk mengetahui status formulir permohonan</p>
          </div> --}}
        </form>
        <form action="{{ URL::to('ktu_print_form/'.$app->id) }}" method="post" accept-charset="utf-8">
          <div class="box box-info">
          <div class="form-horizontal">
            <div class="box-header with-border">
              <h3 class="box-title">Download Surat Yang Telah Di-<i>generate</i> oleh sistem
              </h3>
            </div>
            <div class="box-body">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{ $id }}">
              <div class="col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-block btn-success btn-lg">Download Surat</button>
              </div>
            <!-- /.box-body -->
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- /.row (main row) -->

  </section>
@endsection
